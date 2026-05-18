<?php
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Solicitante'])->group(function () {
    Route::get('/prestamos/mis-prestamos', [PrestamoController::class, 'misPrestamos'])->name('prestamos.usuario');

    Route::get('/prestamos/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');

});


Route::middleware(['auth', 'role:Administrador|Custodio'])->group(function () {

    Route::put('/prestamos/{id}/estado', [PrestamoController::class, 'cambiarEstado'])->name('prestamos.estado');
    Route::get('/prestamos/{id}/editar', [PrestamoController::class, 'edit'])->name('prestamos.edit');
    Route::put('/prestamos/{id}', [PrestamoController::class, 'update'])->name('prestamos.update');

});

Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::delete('/prestamos/{id}', [PrestamoController::class, 'destroy'])->name('prestamos.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/prestamos/gestion', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::get('/prestamos/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::get('/prestamos/{id}', [PrestamoController::class, 'show'])->name('prestamos.show');

});
