<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProductImageController;
use App\Http\Controllers\Seller\ReviewController;



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

    // Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');



// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
Route::post('/orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');
Route::post('/orders/{order}/mark-delivered', [OrderController::class, 'markDelivered'])->name('orders.mark-delivered');

});





