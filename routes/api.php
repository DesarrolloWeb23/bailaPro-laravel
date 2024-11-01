<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Ruta de prueba
Route::get('/test', function (Request $request) {
    return response()->json(['message' => 'Hello World!']);
});


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(JwtMiddleware::class);
    Route::get('/refreshToken', [AuthController::class, 'refresh'])->middleware(JwtMiddleware::class);
    // Route::get('/refreshToken', [AuthController::class, 'refreshToken'])->middleware(JwtMiddleware::class);
});



//Ruta protegida por jwt
Route::get('/protected', function (Request $request) {
    return response()->json(['message' => 'Hello World!']);
})->middleware(JwtMiddleware::class);
