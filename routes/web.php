<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;



// Route yang memerlukan auth (user & admin)
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/orders/{order}/payment', fn($order) => view('user.orders.payment', ['order' => $order]))->name('orders.payment');
Route::post('/orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

    // Profile (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pesanan (user)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/titip-beli', [OrderController::class, 'createTitip'])->name('create.titip');
        Route::post('/', [OrderController::class, 'store'])->name('store');
    });
});

// Route admin (hanya untuk role 'admin')
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD
    Route::resource('menus', MenuController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('promos', PromoController::class);

    // Kelola pesanan
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::put('/{order}', [AdminOrderController::class, 'update'])->name('update');
        // Tidak ada create/store/destroy
    });
});

// Route Breeze (login, register, dll) — sudah di-include di auth.php
require __DIR__.'/auth.php';