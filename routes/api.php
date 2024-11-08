<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//================================================> V1 API  <==================================================================
Route::prefix('v1')->group(function () {

    //================================================> Auth  <==================================================================
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(JwtMiddleware::class);
        Route::get('/refreshToken', [AuthController::class, 'refresh'])->middleware(JwtMiddleware::class);
        // Route::get('/refreshToken', [AuthController::class, 'refreshToken'])->middleware(JwtMiddleware::class);
    });
    //=====================================================> Usuarios <=================================================================
    Route::prefix('/users')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware([JwtMiddleware::class . ':SuperAdmin']);
        Route::post('', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show'])->middleware(JwtMiddleware::class);
        Route::patch('/{id}', [UserController::class, 'update'])->middleware(JwtMiddleware::class);
    });
});
