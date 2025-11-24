<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = $user->getStatistics();
        
        $available_items = $user->items()
            ->where('status', 'available')
            ->count();

        $pending_trades = $user->buyerTransactions()
            ->where('status', 'pending')
            ->count();

        $completed_trades = $user->buyerTransactions()
            ->where('status', 'completed')
            ->count();

        return view('user.dashboard', compact('user', 'stats', 'available_items', 'pending_trades', 'completed_trades'));
    }
}
