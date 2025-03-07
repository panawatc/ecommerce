<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// เพิ่มในไฟล์ routes/web.php
Route::get('/home', function () {
    return redirect('/');
});

// Frontend Routes (ทุกคนเข้าถึงได้)
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Cart Routes - Available to all users
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Authentication Routes
Auth::routes();

// User Routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    // User Profile
    Route::get('/profile', [HomeController::class, 'index'])->name('profile');
    
    // Checkout & Orders - Only for authenticated users
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin Routes (requires authentication and admin role)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Products Management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    
    // Categories Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Orders Management
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});