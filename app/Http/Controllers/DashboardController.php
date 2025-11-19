<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // if admin, show admin dashboard else show user dashboard
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->hasRole('admin')) {
            $users = User::all();
            $transactions = Transaction::with('items.item')->latest()->limit(50)->get();
            return view('admin.dashboard', compact('users', 'transactions'));
        }

        // simple user dashboard: show own items
        $items = $user ? $user->items()->get() : collect();
        return view('dashboard', compact('items'));
    }

}
