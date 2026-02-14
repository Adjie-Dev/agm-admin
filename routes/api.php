<?php

use App\Http\Controllers\PathamaPujaApiController;
use App\Http\Controllers\PujaPagiApiController;
use App\Http\Controllers\KalenderBuddhistController;
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

// Calendar API
Route::get('/calendar/events', [KalenderBuddhistController::class, 'getEventsJson']);