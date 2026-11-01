<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Semua halaman internal membutuhkan login
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Produk
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    // Kategori
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');

    // Pesanan
    Route::resource('orders', OrderController::class)
        ->except(['destroy']);

    // Khusus Admin
    Route::middleware('role:admin')->group(function () {

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
            ->name('orders.destroy');
    });
});
