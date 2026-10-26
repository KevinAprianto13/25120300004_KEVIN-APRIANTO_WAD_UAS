<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - GudangKu Inventory Management System
|--------------------------------------------------------------------------
| Sesuai Tabel F.1 Dokumen Draf UAS WAD04
*/

// Root redirect ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest Authentication Routes (guest middleware)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes (Staff and Admin)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (Tabel F.1: auth)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products Resource (Tabel F.1: auth - index & show untuk semua; create, store, edit, update, destroy dicek role admin)
    Route::resource('products', ProductController::class);

    // Transactions (Tabel F.1: auth)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    // Admin Exclusive Routes (Tabel F.1: auth, role:admin)
    Route::middleware('role:admin')->group(function () {
        // Categories Resource CRUD
        Route::resource('categories', CategoryController::class);

        // User Management Resource CRUD
        Route::resource('users', UserController::class);
    });
});
