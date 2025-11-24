<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalItems' => Item::count(),
            'totalTransactions' => Transaction::count(),
            'completedTransactions' => Transaction::where('status', 'completed')->count(),
            'pendingTransactions' => Transaction::where('status', 'pending')->count(),
            'users' => User::where('role', 'user')->latest()->take(10)->get(),
            'recentTransactions' => Transaction::latest()->take(10)->get(),
        ]);
    }

    public function users()
    {
        return view('admin.users.index', [
            'users' => User::where('role', 'user')->paginate(20),
        ]);
    }

    public function items()
    {
        return view('admin.items.index', [
            'items' => Item::with('user')->paginate(20),
        ]);
    }

    public function transactions()
    {
        return view('admin.transactions.index', [
            'transactions' => Transaction::with('buyer', 'seller', 'item')->paginate(20),
        ]);
    }
}
