<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DhammavachanaController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes - HANYA untuk yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout - untuk yang sudah login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes - HARUS login dulu
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dhammavachana', [DhammavachanaController::class, 'index'])->name('dhammavachana.index');
    Route::get('/dhammavachana/create', [DhammavachanaController::class, 'create'])->name('dhammavachana.create');
    Route::post('/dhammavachana', [DhammavachanaController::class, 'store'])->name('dhammavachana.store');
    Route::get('/dhammavachana/{dhammavachana}', [DhammavachanaController::class, 'show'])->name('dhammavachana.show');
    Route::get('/dhammavachana/{dhammavachana}/edit', [DhammavachanaController::class, 'edit'])->name('dhammavachana.edit');
    Route::put('/dhammavachana/{dhammavachana}', [DhammavachanaController::class, 'update'])->name('dhammavachana.update');
    Route::delete('/dhammavachana/{dhammavachana}', [DhammavachanaController::class, 'destroy'])->name('dhammavachana.destroy');
});
