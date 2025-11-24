<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['buyer', 'seller', 'item'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('buyer', 'seller', 'item', 'offerItem');
        return view('admin.transactions.show', compact('transaction'));
    }

    public function cancel(Transaction $transaction)
    {
        if (!$transaction->isPending()) {
            return back()->with('error', 'Cannot cancel completed or rejected transactions');
        }

        $transaction->cancel();
        return back()->with('success', 'Transaction cancelled successfully');
    }
}
