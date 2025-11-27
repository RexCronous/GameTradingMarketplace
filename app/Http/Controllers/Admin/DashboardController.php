<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_items' => Item::count(),
            'total_transactions' => Transaction::count(),
            'pending_trades' => Transaction::where('status', 'pending')->count(),
            'completed_trades' => Transaction::where('status', 'completed')->count(),
            'total_revenue' => Transaction::where('status', 'completed')->sum('total_price'),
            'items_sold' => Item::where('status', 'sold')->count(),
            'items_traded' => Item::where('status', 'traded')->count(),
        ];

        $recent_transactions = Transaction::with(['buyer', 'seller', 'item'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recent_users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_transactions', 'recent_users'));
    }
}
