<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        Gate::define('permiso', function (Usuario $usuario, string $nombrePermiso): bool {
            return $usuario->tienePermiso($nombrePermiso);
        });
    }
}
