<?php

use App\Http\Controllers\AmituojingApiController;
use App\Http\Controllers\PathamaPujaApiController;
use App\Http\Controllers\PujaPagiApiController;
use App\Http\Controllers\KalenderBuddhistController;
use App\Http\Controllers\PujaSoreApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Pathama Puja API
Route::get('/pathama-puja', [PathamaPujaApiController::class, 'index']);
Route::get('/pathama-puja/{urutan}', [PathamaPujaApiController::class, 'show']);

// Puja Pagi API
Route::get('/puja-pagi', [PujaPagiApiController::class, 'index']);
Route::get('/puja-pagi/{urutan}', [PujaPagiApiController::class, 'show']);

// Puja Sore API
Route::get('/puja-sore', [PujaSoreApiController::class, 'index']);
Route::get('/puja-sore/{urutan}', [PujaSoreApiController::class, 'show']);

// Amituojing API
Route::get('/amituojing', [AmituojingApiController::class, 'index']);
Route::get('/amituojing/{urutan}', [AmituojingApiController::class, 'show']);

// Calendar API
Route::get('/calendar/events', [KalenderBuddhistController::class, 'getEventsJson']);
