<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    //================================================> Auth  <==================================================================
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(JwtMiddleware::class);
        Route::get('/refreshToken', [AuthController::class, 'refresh'])->middleware(JwtMiddleware::class);
        // Route::get('/refreshToken', [AuthController::class, 'refreshToken'])->middleware(JwtMiddleware::class);
    });

    //================================================> Usuarios  <==================================================================
    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware(JwtMiddleware::class);
        Route::post('', [UserController::class, 'store'])->middleware(JwtMiddleware::class);
        Route::put('/{id}', [UserController::class, 'update'])->middleware(JwtMiddleware::class);
        Route::patch('/{id}', [UserController::class, 'update'])->middleware(JwtMiddleware::class);
    });
});


//Ruta protegida por jwt
Route::get('/protected', function (Request $request) {
    return response()->json(['message' => 'Hello World!']);
})->middleware(JwtMiddleware::class);
