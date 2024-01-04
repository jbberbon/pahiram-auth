<?php

use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/logout', [AuthController::class, 'logout']);
    Route::post('/user/logout-all-device', [AuthController::class, 'revokeAllTokens']);

    // CRUD {USERS & COURSES}
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{apc_id}', [UserController::class, 'show']);
        Route::delete('/{userId}', [UserController::class, 'destroy']);
        Route::get('/search/{name}', [UserController::class, 'search']);
    });
    Route::get('/courses', [CourseController::class, 'index']);

    Route::group(['middleware' => ['is_employee']], function () {
        Route::get('/courses/{course}', [CourseController::class, 'show']);
        Route::post('/courses', [CourseController::class, 'store']);
        Route::patch('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
    });
});




