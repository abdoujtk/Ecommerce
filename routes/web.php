<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\SellerController;


Route::get('/', function () {
    return view('welcome');
});

// Breeze auth routes (login, register, logout, password reset)
require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {  

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Sellers
    Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');
    Route::post('/sellers/{user}/approve', [SellerController::class, 'approve'])->name('sellers.approve');
    Route::post('/sellers/{user}/ban', [SellerController::class, 'ban'])->name('sellers.ban');
    Route::post('/sellers/{user}/unban', [SellerController::class, 'unban'])->name('sellers.unban');
    Route::delete('/sellers/{user}', [SellerController::class, 'destroy'])->name('sellers.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
});

// Seller routes
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {

    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

    // Store
    Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [StoreController::class, 'update'])->name('store.update');

});





