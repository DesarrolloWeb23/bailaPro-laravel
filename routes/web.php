<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Usuarios;
use App\Livewire\Teacher;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

// Prefijo para usuarios
    Route::prefix('usr')->group(function () {
        Route::get('r', Usuarios::class)->name('usr.r'); // Leer usuarios
        Route::post('c', [Usuarios::class, 'save'])->name('usr.c'); // Crear usuario
    });

// Prefijo para los usuarios de tipo maestro
    Route::prefix('tch')->group(function () {
        Route::get('r', Teacher::class)->name('tch.r'); 
    });
});
