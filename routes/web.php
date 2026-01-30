<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DhammavachanaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EbookController;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dhammavachana', DhammavachanaController::class);

    // Route untuk upload gambar dari TinyMCE editor
    Route::post('/articles/upload-image', [ArticleController::class, 'uploadImage'])->name('articles.upload-image');

    Route::resource('articles', ArticleController::class);
    Route::resource('ebooks', EbookController::class);
});
