<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $transactions = Transaction::where(function($q) use ($userId) {
            $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
        })->with('buyer', 'seller', 'item', 'offerItem')->latest()->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $userId = Auth::id();
        if ($transaction->buyer_id !== $userId && $transaction->seller_id !== $userId) {
            abort(403, 'Unauthorized');
        }

        return view('transactions.show', compact('transaction'));
    }

    public function offers()
    {
        $offers = Transaction::where('seller_id', Auth::id())
            ->where('status', 'pending')
            ->with('buyer', 'item', 'offerItem')
            ->latest()
            ->paginate(20);

        return view('transactions.offers', compact('offers'));
    }

    public function accept(Transaction $transaction)
    {
        if ($transaction->seller_id !== Auth::id()) {
            abort(403, 'Only seller can accept offers');
        }

        $transaction->accept();

        return redirect()->back()->with('success', 'Offer accepted successfully!');
    }

    public function reject(Transaction $transaction)
    {
        if ($transaction->seller_id !== Auth::id()) {
            abort(403, 'Only seller can reject offers');
        }

        $transaction->reject();

        return redirect()->back()->with('success', 'Offer rejected successfully!');
    }

    public function store(StoreTransactionRequest $request)
    {
        $item = Item::findOrFail($request->item_id);

        if ($item->user_id === Auth::id()) {
            return back()->withErrors(['error' => 'Cannot trade with your own items']);
        }

        if (!$item->isAvailable()) {
            return back()->withErrors(['error' => 'Item is not available for trading']);
        }

        $transaction = new Transaction([
            'buyer_id' => Auth::id(),
            'seller_id' => $item->user_id,
            'item_id' => $item->id,
            'type' => $request->type,
            'status' => 'pending',
            'message' => $request->message,
        ]);

        if ($request->type === 'trade' && $request->offer_item_id) {
            $offerItem = Item::findOrFail($request->offer_item_id);
            if ($offerItem->user_id !== Auth::id() || !$offerItem->canBeTraded()) {
                return back()->withErrors(['error' => 'Invalid offer item']);
            }
            $transaction->offer_item_id = $offerItem->id;
        } elseif ($request->type === 'buy' && $request->offer_amount) {
            $transaction->offer_amount = $request->offer_amount;
        }

        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Offer sent successfully!');
    }
}
