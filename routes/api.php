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
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\QuestionController;

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

////////testing user for AI///////////
// fetsh the test answer of user
Route::get('/user_test_answers/{id}', [AnswerController::class, 'getUserTestAnswers']);
// update the test result (score) of user
Route::put('/update_test_result/{id}', [TestController::class, 'updateTestResult']);



///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////


Route::middleware(['auth:sanctum', AllAccess::class])->group(function () {

    //show all job posts
    Route::get('/posts', [PostController::class, 'index']);
     //User Profile
    Route::post('/update-user-info', [ProfileController::class, 'updateUserInfo']);
    Route::get('/employer/posts/show/{id}', [PostController::class, 'show']);





    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////
    // Routes for admin users
    Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
        Route::get('/admin', function (Request $request) {
            return $request->user();
        });
        //Report
        Route::get('/reports', [ReportController::class, 'index']);
        Route::put('/reports/update/{id}', [ReportController::class, 'update']);

        Route::get('/employer-requests', [EmployerController::class, 'index']);
        Route::post('/handle-employer/{user_id}', [EmployerController::class, 'handleRequest']);
    });

    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////



    // Routes for user middleware

    Route::middleware(['auth:sanctum', UserMiddleware::class])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        //Logout
        Route::get('/logout', [AuthController::class, 'logout']);
        //CV's
        Route::get('/cvs', [CvController::class, 'index']);
        Route::get('/cvs/show/{id?}', [CvController::class, 'show']);
        Route::post('/cvs/store', [CvController::class, 'store']);
        Route::put('/cvs/update/{id?}', [CvController::class, 'update']);
        Route::delete('/cvs/{id}', [CvController::class, 'destroy']);
        //Languages
        Route::get('/languages/show', [LanguageController::class, 'index']);
        Route::post('/languages/store', [LanguageController::class, 'store']);
        Route::put('/languages/update/{id}', [LanguageController::class, 'update']);
        Route::delete('/languages/delete/{id}', [LanguageController::class, 'destroy']);

        //experience
        Route::get('/experiences/show/{id?}', [ExperienceController::class, 'index']);
        Route::post('/experiences/store', [ExperienceController::class, 'store']);
        Route::put('/experiences/update/{id}', [ExperienceController::class, 'update']);
        Route::delete('/experiences/delete/{id}', [ExperienceController::class, 'destroy']);

        //report
        Route::post('/reports/store', [ReportController::class, 'store']);
        Route::get('/reports/user/show', [ReportController::class, 'userReports']);
        //upgrade role from user to employer
        Route::post('/apply-employer', [EmployerController::class, 'apply'])->name('apply.employer');

        //answers
        Route::post('/answers/store', [AnswerController::class, 'store']);

        //tests
        Route::get('/questions', [TestController::class, 'getAllQuestions']);
        Route::get('/questions/{id}', [TestController::class, 'getQuestionsById']);
        Route::post('/submit_answers', [TestController::class, 'storeAnswers']);
    });


    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////
    // Routes for employer middleware
    Route::middleware(['auth:sanctum', EmployerMiddleware::class])->group(function () {
        Route::get('/employer', function (Request $request) {
            return $request->user();
        });
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
