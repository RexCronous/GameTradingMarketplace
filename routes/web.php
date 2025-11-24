<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public marketplace
Route::get('/marketplace', [ItemController::class, 'index'])->name('marketplace.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Item management
    Route::resource('items', ItemController::class)->except(['index', 'show']);

    // Transactions and trades
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::post('/items/{item}/buy', [TransactionController::class, 'buyItem'])->name('items.buy');
    Route::post('/items/{item}/trade', [TransactionController::class, 'initiateTrade'])->name('items.trade');
    Route::post('/transactions/{transaction}/accept', [TransactionController::class, 'acceptTransaction'])->name('transactions.accept');
    Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'rejectTransaction'])->name('transactions.reject');
    Route::post('/transactions/{transaction}/complete', [TransactionController::class, 'completeTransaction'])->name('transactions.complete');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';

