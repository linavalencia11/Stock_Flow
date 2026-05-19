<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        //si no esta autenticado, redirigir al login
        if (!auth()->check())
        {
            return redirect('login');
        }

        //captura los roles permitidos en el middleware y los convierte en un array
        $allowedRoles = explode('|', $roles);
        //captura el rol del usuario autenticado
        $userRole = auth()->user()->rol->nombre;
        //verifica si el rol del usuario esta en el array de roles permitidos
        if (!in_array($userRole, $allowedRoles))
        {
            abort(403, 'LOCOTA TRATANDO DE ENTRAR A UNA PAGINA QUE NO LE PERTENECE');
        }

        return $next($request);
    }
}
