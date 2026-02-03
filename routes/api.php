<?php

use App\Http\Controllers\PathamaPujaApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Pathama Puja API
Route::get('/pathama-puja', [PathamaPujaApiController::class, 'index']);
Route::get('/pathama-puja/{urutan}', [PathamaPujaApiController::class, 'show']);