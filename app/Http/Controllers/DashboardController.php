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

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard', [
            'totalItems' => $user->items()->count(),
            'completedTrades' => $user->buyerTransactions()->where('status', 'completed')->count() + 
                               $user->sellerTransactions()->where('status', 'completed')->count(),
            'pendingOffers' => $user->sellerTransactions()->where('status', 'pending')->count(),
            'totalPlayers' => User::where('role', 'user')->count(),
            'recentItems' => $user->items()->latest()->take(5)->get(),
            'recentTransactions' => Transaction::where(function($q) use ($user) {
                $q->where('buyer_id', $user->id)->orWhere('seller_id', $user->id);
            })->latest()->take(5)->get(),
        ]);
    }
}
