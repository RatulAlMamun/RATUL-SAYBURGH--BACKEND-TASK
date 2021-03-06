<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('refresh',[AuthController::class, 'refresh']);
    });

    Route::prefix('posts')->group(function () {
        Route::get('index', [PostController::class, 'index']);
        Route::post('store', [PostController::class, 'store']);
        Route::put('update/{id}', [PostController::class, 'update']);
        Route::get('show/{id}', [PostController::class, 'show']);
        Route::delete('destroy/{id}', [PostController::class, 'destroy']);
    });
   
    Route::prefix('comments')->group(function () {
        Route::get('index', [CommentController::class, 'index']);
        Route::post('store', [CommentController::class, 'store']);
        Route::put('update/{id}', [CommentController::class, 'update']);
        Route::delete('destroy/{id}', [CommentController::class, 'destroy']);
    });

    Route::prefix('replies')->group(function () {
        Route::post('store', [ReplyController::class, 'store']);
        Route::put('update/{id}', [ReplyController::class, 'update']);
        Route::delete('destroy/{id}', [ReplyController::class, 'destroy']);
    });

    Route::prefix('tags')->group(function () {
        Route::get('index', [TagController::class, 'index']);
        Route::post('store', [TagController::class, 'store']);
        Route::put('update/{id}', [TagController::class, 'update']);
        Route::delete('destroy/{id}', [TagController::class, 'destroy']);
    });
});
