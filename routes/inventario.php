<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

// Rutas estáticas de artículos ANTES que las dinámicas /{id}
Route::middleware(['auth', 'permission:catalogo.ver_lista'])->group(function () {
    Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
});

Route::middleware(['auth', 'permission:stock.agregar_articulo'])->group(function () {
    Route::get('/articulos/create', [ArticuloController::class, 'create'])->name('articulos.create');
    Route::post('/articulos', [ArticuloController::class, 'store'])->name('articulos.store');
});

Route::middleware(['auth', 'permission:stock.editar_articulo|stock.cambiar_estado'])->group(function () {
    Route::get('/articulos/{id}/edit', [ArticuloController::class, 'edit'])->name('articulos.edit');
    Route::put('/articulos/{id}', [ArticuloController::class, 'update'])->name('articulos.update');
});

Route::middleware(['auth', 'permission:stock.dar_baja_articulo'])->group(function () {
    Route::delete('/articulos/{id}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');
});

Route::middleware(['auth', 'permission:catalogo.ver_detalle'])->group(function () {
    Route::get('/articulos/{id}', [ArticuloController::class, 'show'])->name('articulos.show');
});

// Categorías: create también antes que /{id}
Route::middleware(['auth', 'permission:stock.gestionar_categorias'])->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::get('/categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
});
