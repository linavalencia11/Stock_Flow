<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Verifica que el usuario autenticado tenga al menos uno de los permisos indicados.
     * Varios permisos se separan con | (lógica OR).
     *
     * Uso: middleware('permission:prestamos.solicitar')
     *      middleware('permission:prestamos.aprobar_rechazar|prestamos.registrar_entrega')
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $usuario = auth()->user();

        foreach (explode('|', $permissions) as $permiso) {
            if ($usuario->tienePermiso(trim($permiso))) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
