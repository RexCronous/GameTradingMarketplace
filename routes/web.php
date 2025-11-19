<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // item management
    Route::resource('items', ItemController::class);
    // admin management (users & roles)
    Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('role:admin');
    Route::resource('roles', \App\Http\Controllers\RoleController::class)->middleware('role:admin');
    // offers
    Route::resource('offers', OfferController::class);
    Route::post('offers/{offer}/accept', [OfferController::class, 'accept'])->name('offers.accept');
    Route::post('offers/{offer}/reject', [OfferController::class, 'reject'])->name('offers.reject');
    // transactions
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('role:admin');
});

require __DIR__.'/auth.php';
