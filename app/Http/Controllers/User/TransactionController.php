<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Item;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $purchased = $user->buyerTransactions()
            ->with(['item', 'seller', 'offerItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $sold = $user->sellerTransactions()
            ->with(['item', 'buyer', 'offerItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.transactions.index', compact('purchased', 'sold'));
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();
        
        if ($transaction->buyer_id !== $user->id && $transaction->seller_id !== $user->id) {
            abort(403);
        }

        $transaction->load('item', 'buyer', 'seller', 'offerItem');
        $is_seller = $transaction->seller_id === $user->id;

        return view('user.transactions.show', compact('transaction', 'is_seller'));
    }

    public function create(Item $item)
    {
        if ($item->user_id === Auth::id()) {
            abort(403, 'Cannot trade your own item');
        }

        if (!$item->isAvailable()) {
            abort(403, 'Item is no longer available');
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user_items = $user->items()
            ->where('status', 'available')
            ->get();

        return view('user.transactions.create', compact('item', 'user_items'));
    }

    public function store(StoreTransactionRequest $request, Item $item)
    {
        if ($item->user_id === Auth::id()) {
            return back()->with('error', 'Cannot trade your own item');
        }

        if (!$item->isAvailable()) {
            return back()->with('error', 'Item is no longer available');
        }

        $data = $request->validated();

        $transaction = Transaction::create([
            'item_id' => $item->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $item->user_id,
            'offer_item_id' => $data['offer_item_id'] ?? null,
            'offer_amount' => $data['offer_amount'] ?? null,
            'total_price' => $data['total_price'] ?? $item->price,
            'type' => $data['type'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('user.transactions.show', $transaction)
            ->with('success', 'Trade request sent successfully');
    }

    public function accept(Transaction $transaction)
    {
        $user = Auth::user();
        
        if ($transaction->seller_id !== $user->id) {
            abort(403, 'Only seller can accept this trade');
        }

        if (!$transaction->canBeAccepted()) {
            return back()->with('error', 'This trade cannot be accepted');
        }

        if ($transaction->isTradeType() && $transaction->offerItem && $transaction->offerItem->user_id !== $user->id) {
            abort(403, 'Invalid trade offer');
        }

        $transaction->accept();

        return back()->with('success', 'Trade accepted successfully');
    }

    public function reject(Transaction $transaction)
    {
        $user = Auth::user();
        
        if ($transaction->seller_id !== $user->id) {
            abort(403, 'Only seller can reject this trade');
        }

        if (!$transaction->canBeRejected()) {
            return back()->with('error', 'This trade cannot be rejected');
        }

        $transaction->reject();

        return back()->with('success', 'Trade rejected successfully');
    }

    public function complete(Transaction $transaction)
    {
        $user = Auth::user();
        
        if ($transaction->buyer_id !== $user->id && $transaction->seller_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        if (!$transaction->isAccepted()) {
            return back()->with('error', 'Only accepted trades can be completed');
        }

        if ($transaction->isTradeType()) {
            if (!$transaction->offerItem || $transaction->offerItem->user_id !== $transaction->buyer_id) {
                return back()->with('error', 'Invalid trade offer item');
            }
        }

        $transaction->complete();

        return back()->with('success', 'Trade completed successfully');
    }
}
