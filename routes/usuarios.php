<?php
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RolController::class);

});
