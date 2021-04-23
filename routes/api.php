<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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
    });
   
});
