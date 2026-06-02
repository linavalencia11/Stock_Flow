<?php

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PermisoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:administracion.registrar_usuarios'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
});

Route::middleware(['auth', 'permission:administracion.editar_usuarios_roles'])->group(function () {
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::resource('roles', RolController::class);
});

Route::middleware(['auth', 'permission:administracion.desactivar_usuarios'])->group(function () {
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

Route::middleware(['auth' , 'permission:permisos.ver_lista'])->group(function () {
    Route::resource('permisos', PermisoController::class);
});
