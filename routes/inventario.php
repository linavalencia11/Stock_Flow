<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

// Capa de lectura (Cualquiera ve artículos y categorías)
Route::middleware(['auth', 'role:Administrador|Custodio|Solicitante'])->group(function () {
    Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
    Route::get('/articulos/{id}', [ArticuloController::class, 'show'])->name('articulos.show');

    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
});

// Capa de escritura (Admin y Custodio crean/editan)
Route::middleware(['auth', 'role:Administrador|Custodio'])->group(function () {
    Route::get('/articulos/create', [ArticuloController::class, 'create'])->name('articulos.create');
    Route::post('/articulos', [ArticuloController::class, 'store'])->name('articulos.store');
    Route::get('/articulos/{id}/edit', [ArticuloController::class, 'edit'])->name('articulos.edit');
    Route::put('/articulos/{id}', [ArticuloController::class, 'update'])->name('articulos.update');

    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
});

// Capa crítica (Solo Admin elimina)
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::delete('/articulos/{id}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');
    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
});
