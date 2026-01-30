<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DhammavachanaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\KalenderBuddhistController;

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

    // Routes untuk Kalender Buddhist
    Route::prefix('kalender-buddhist')->name('kalender-buddhist.')->group(function () {
        Route::get('/', [KalenderBuddhistController::class, 'index'])->name('index');
        Route::get('/create', [KalenderBuddhistController::class, 'create'])->name('create');
        Route::post('/', [KalenderBuddhistController::class, 'store'])->name('store');
        Route::get('/{acaraBuddhist}/edit', [KalenderBuddhistController::class, 'edit'])->name('edit');
        Route::put('/{acaraBuddhist}', [KalenderBuddhistController::class, 'update'])->name('update');
        Route::delete('/{acaraBuddhist}', [KalenderBuddhistController::class, 'destroy'])->name('destroy');
        Route::post('/{acaraBuddhist}/toggle', [KalenderBuddhistController::class, 'toggleAktif'])->name('toggle');
    });
});
