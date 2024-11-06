<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;


// Apply session middleware to routes that need it
Route::middleware([StartSession::class])->group(function () {
    Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes for authentication
Route::post('/login', [AuthController::class, 'login']);


// Routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/update-user-info', [ProfileController::class, 'updateUserInfo']);
    Route::post('/verify-email', [ProfileController::class, 'verifyEmail']);


    Route::get('/logout', [AuthController::class, 'logout']);




Route::get('posts', [PostController::class, 'index']);
Route::post('posts/store', [PostController::class, 'store']);
Route::get('posts/show/{id}', [PostController::class, 'show']);
Route::put('posts/update/{id}', [PostController::class, 'update']);
Route::delete('posts/delete/{id}', [PostController::class, 'destroy']);




});


Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');




//posts:




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Email verification routes
///Route::middleware(['auth:sanctum', 'signed'])->group(function () {
/*
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();


        return response()->json(['message' => 'Email verified successfully']);
    })->name('verification.verify');

    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent'], 200);
    })->name('verification.send');


   */



///////});
