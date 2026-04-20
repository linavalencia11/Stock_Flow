<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PrestamoController;



// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('articulos.index'));

    Route::resource('articulos', ArticuloController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RolController::class);
    Route::resource('prestamos', PrestamoController::class);
});
