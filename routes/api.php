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
use App\Http\Middleware\AllAccess;
use App\Http\Controllers\CvController;
use App\Http\Controllers\LanguageController;


///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
// Apply session middleware to routes that need it
Route::middleware([StartSession::class])->group(function () {
    Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([StartSession::class])->group(function () {
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');
});


///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////


Route::middleware(['auth:sanctum', AllAccess::class])->group(function () {
    Route::get('/posts', [PostController::class, 'index']);

    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////
    // Routes for admin users
    Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
        Route::get('/admin', function (Request $request) {
            return $request->user();
        });
    });

    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////



    // Routes for user middleware

    Route::middleware(['auth:sanctum', UserMiddleware::class])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        //User Profile
        Route::post('/update-user-info', [ProfileController::class, 'updateUserInfo']);
        Route::post('/verify-email', [ProfileController::class, 'verifyEmail']);
        //Logout
        Route::get('/logout', [AuthController::class, 'logout']);
        //CV's
        Route::get('/cvs', [CvController::class, 'index']);
        Route::get('/cvs/show/{id?}', [CvController::class, 'show']);
        Route::post('/cvs/store', [CvController::class, 'store']);
        Route::put('/cvs/update/{id?}', [CvController::class, 'update']);
        Route::delete('/cvs/{id}', [CvController::class, 'destroy']);
        //Languages
        Route::post('/languages/store', [LanguageController::class, 'store']);
        Route::put('/languages/update/{id}', [LanguageController::class, 'update']);
        Route::delete('/languages/delete/{id}', [LanguageController::class, 'destroy']);
    });


    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////
    // Routes for employer middleware
    Route::middleware(['auth:sanctum', EmployerMiddleware::class])->group(function () {
        Route::get('/employer', function (Request $request) {
            return $request->user();
        });

        Route::get('/employer/posts/show/{id}', [PostController::class, 'show']);
        Route::put('/employer/posts/update/{id}', [PostController::class, 'update']);
        Route::delete('/employer/posts/delete/{id}', [PostController::class, 'destroy']);
    });


    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////
    // Routes for posts that both admin and employer can access
    Route::middleware(['auth:sanctum', AdminOrEmployerMiddleware::class])->group(function () {
        Route::post('/posts/store', [PostController::class, 'store']);
    });
    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////





});
