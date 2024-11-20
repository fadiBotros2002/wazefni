<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\EmployerMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminOrEmployerMiddleware;

// Apply session middleware to routes that need it
Route::middleware([StartSession::class])->group(function () {
    Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes for authentication
Route::post('/login', [AuthController::class, 'login']);

// Apply session middleware to routes that need it
Route::middleware([StartSession::class])->group(function (){
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');
});


// Routes for admin users
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::get('/admin', function (Request $request) {
        return $request->user();
    });
});

// Routes for user middleware
Route::middleware(['auth:sanctum', UserMiddleware::class])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/update-user-info', [ProfileController::class, 'updateUserInfo']);
    Route::post('/verify-email', [ProfileController::class, 'verifyEmail']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

// Routes for employer middleware
Route::middleware(['auth:sanctum', EmployerMiddleware::class])->group(function () {
    Route::get('/employer', function (Request $request) {
        return $request->user();
    });

    Route::get('/employer/posts/show/{id}', [PostController::class, 'show']);
    Route::put('/employer/posts/update/{id}', [PostController::class, 'update']);
    Route::delete('/employer/posts/delete/{id}', [PostController::class, 'destroy']);
});

// Routes for posts that both admin and employer can access
Route::middleware(['auth:sanctum', AdminOrEmployerMiddleware::class])->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts/store', [PostController::class, 'store']);
});

// Email verification routes
/*
Route::middleware(['auth:sanctum', 'signed'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully']);
    })->name('verification.verify');

    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent'], 200);
    })->name('verification.send');
});
*/
