<?php

use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Solicitante|Custodio|Administrador'])->group(function () {
    Route::get('/reportes/mis-prestamos', [ReporteController::class, 'misPrestamos'])->name('reportes.mis-prestamos');
});

Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/reportes/general', [ReporteController::class, 'reporteGeneral'])->name('reportes.general');
    Route::get('/reportes/articulos-solicitados', [ReporteController::class, 'articulosSolicitados'])->name('reportes.articulos-solicitados');
});
