<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    public function adminDashboard()
    {
        $totalUsers = User::count('id');
        $totalItems = Item::count('id');
        $totalTransactions = Transaction::count('id');
        $pendingTransactions = Transaction::where('status', '==',  'pending', true)->count();
        $completedTransactions = Transaction::where('status','==', 'completed', true)->count();
        
        $recentTransactions = Transaction::with('buyer', 'seller', 'item')
            ->latest()
            ->take(10)
            ->get();

        $users = User::withCount(['items', 'transactionsBought', 'transactionsSold'])
            ->latest()
            ->paginate(15);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalItems',
            'totalTransactions',
            'pendingTransactions',
            'completedTransactions',
            'recentTransactions',
            'users'
        ));
    }

    public function userDashboard()
    {
        $user = Auth::user();
        
        $myItems = $user->items()->count();
        $myTransactions = $user->transactionsBought()->count() + $user->transactionsSold()->count();
        $pendingOffers = Transaction::where(function ($query) use ($user) {
            $query->where('seller_id', $user->id)
                  ->orWhere('buyer_id', $user->id);
        })->where('status', 'pending')->count();

        $userItems = $user->items()
            ->latest()
            ->paginate(10);

        $myPendingTrades = Transaction::where(function ($query) use ($user) {
            $query->where('seller_id', $user->id)
                  ->orWhere('buyer_id', $user->id);
        })
            ->where('status', 'pending')
            ->with('buyer', 'seller', 'item', 'offerItem')
            ->latest()
            ->paginate(10);

        return view('user.dashboard', compact(
            'user',
            'myItems',
            'myTransactions',
            'pendingOffers',
            'userItems',
            'myPendingTrades'
        ));
    }
}
