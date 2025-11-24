<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        $transactions = Transaction::where(function ($query) use ($userId) {
            $query->where('buyer_id', $userId)
                  ->orWhere('seller_id', $userId);
        })
            ->with('buyer', 'seller', 'item', 'offerItem')
            ->latest()
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        $transaction->load('buyer', 'seller', 'item', 'offerItem');

        return view('transactions.show', compact('transaction'));
    }

    public function buyItem(Item $item)
    {
        if (Auth::id() === $item->user_id) {
            return back()->with('error', 'You cannot buy your own items!');
        }

        if ($item->status !== 'available') {
            return back()->with('error', 'This item is not available for purchase.');
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $item->user_id,
                'item_id' => $item->id,
                'total_price' => $item->price,
                'type' => 'buy',
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Buy request created! Waiting for seller confirmation.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create buy request.');
        }
    }

    public function initiateTrade(Request $request, Item $item)
    {
        if (Auth::id() === $item->user_id) {
            return back()->with('error', 'You cannot trade your own items!');
        }

        if ($item->status !== 'available') {
            return back()->with('error', 'This item is not available for trading.');
        }

        $request->validate([
            'offer_item_id' => 'nullable|exists:items,id',
            'offer_amount' => 'nullable|numeric|min:0',
        ]);

        if (!$request->offer_item_id && !$request->offer_amount) {
            return back()->with('error', 'Provide either an item or an amount to trade.');
        }

        if ($request->offer_item_id) {
            $offerItem = Item::find($request->offer_item_id);
            if (!$offerItem || $offerItem->user_id !== Auth::id() || $offerItem->status !== 'available') {
                return back()->with('error', 'Invalid offer item.');
            }
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $item->user_id,
                'item_id' => $item->id,
                'offer_item_id' => $request->offer_item_id,
                'offer_amount' => $request->offer_amount,
                'type' => 'trade',
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Trade offer created! Waiting for seller response.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create trade offer.');
        }
    }

    public function acceptTransaction(Transaction $transaction)
    {
        $this->authorize('accept', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'This transaction cannot be accepted.');
        }

        try {
            DB::beginTransaction();

            // Update transaction status
            $transaction->update(['status' => 'accepted']);

            // Update item status
            $transaction->item->update(['status' => 'sold']);

            // If trade with item, update the offered item status too
            if ($transaction->offer_item_id) {
                $transaction->offerItem->update(['status' => 'traded']);
            }

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Trade accepted! Transaction completed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to accept transaction.');
        }
    }

    public function rejectTransaction(Transaction $transaction)
    {
        $this->authorize('reject', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'This transaction cannot be rejected.');
        }

        $transaction->update(['status' => 'rejected']);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction rejected.');
    }

    public function completeTransaction(Transaction $transaction)
    {
        if ($transaction->status !== 'accepted') {
            return back()->with('error', 'Only accepted transactions can be completed.');
        }

        $transaction->update(['status' => 'completed']);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction completed!');
    }
}

