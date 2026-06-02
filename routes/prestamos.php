<?php

use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:reportes.ver_mis_prestamos'])->group(function () {
    Route::get('/prestamos/mis-prestamos', [PrestamoController::class, 'misPrestamos'])->name('prestamos.usuario');
});

Route::middleware(['auth', 'permission:prestamos.solicitar'])->group(function () {
    Route::get('/prestamos/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
});

Route::middleware(['auth', 'permission:prestamos.ver_todos_activos'])->group(function () {
    Route::get('/prestamos/gestion', [PrestamoController::class, 'index'])->name('prestamos.index');
});

Route::middleware(['auth', 'permission:reportes.ver_reporte_general'])->group(function () {
    Route::delete('/prestamos/{id}', [PrestamoController::class, 'destroy'])->name('prestamos.destroy');
});

Route::middleware([
    'auth',
    'permission:prestamos.aprobar_rechazar|prestamos.registrar_entrega|prestamos.registrar_devolucion',
])->group(function () {
    Route::get('/prestamos/{id}/editar', [PrestamoController::class, 'edit'])->name('prestamos.edit');
    Route::put('/prestamos/{id}', [PrestamoController::class, 'update'])->name('prestamos.update');
});

Route::middleware([
    'auth',
    'permission:prestamos.ver_todos_activos|reportes.ver_mis_prestamos|prestamos.ver_fecha_limite_devolucion',
])->group(function () {
    Route::get('/prestamos/{id}', [PrestamoController::class, 'show'])->name('prestamos.show');
});
