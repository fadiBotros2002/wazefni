<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;

// Routes for authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class,'register']);



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    Route::get('/logout', [AuthController::class,'logout']);


});


