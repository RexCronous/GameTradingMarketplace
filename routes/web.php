<?php

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ItemController as UserItemController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\MarketplaceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // User Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');

    // User Items Management
    Route::prefix('items')->name('user.items.')->group(function () {
        Route::get('/', [UserItemController::class, 'index'])->name('index');
        Route::get('/create', [UserItemController::class, 'create'])->name('create');
        Route::post('/', [UserItemController::class, 'store'])->name('store');
        Route::get('/{item}/edit', [UserItemController::class, 'edit'])->name('edit');
        Route::put('/{item}', [UserItemController::class, 'update'])->name('update');
        Route::delete('/{item}', [UserItemController::class, 'destroy'])->name('destroy');
    });

    // Marketplace
    Route::prefix('marketplace')->name('user.marketplace.')->group(function () {
        Route::get('/', [MarketplaceController::class, 'index'])->name('index');
        Route::get('/{item}', [MarketplaceController::class, 'show'])->name('show');
    });

    // User Transactions
    Route::prefix('transactions')->name('user.transactions.')->group(function () {
        Route::get('/', [UserTransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [UserTransactionController::class, 'show'])->name('show');
        Route::get('/item/{item}/create', [UserTransactionController::class, 'create'])->name('create');
        Route::post('/item/{item}', [UserTransactionController::class, 'store'])->name('store');
        Route::post('/{transaction}/accept', [UserTransactionController::class, 'accept'])->name('accept');
        Route::post('/{transaction}/reject', [UserTransactionController::class, 'reject'])->name('reject');
        Route::post('/{transaction}/complete', [UserTransactionController::class, 'complete'])->name('complete');
    });

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('items')->name('items.')->group(function () {
            Route::get('/', [AdminItemController::class, 'index'])->name('index');
            Route::get('/{item}', [AdminItemController::class, 'show'])->name('show');
            Route::delete('/{item}', [AdminItemController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
            Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
            Route::post('/{transaction}/cancel', [AdminTransactionController::class, 'cancel'])->name('cancel');
        });
    });
});

require __DIR__.'/auth.php';
