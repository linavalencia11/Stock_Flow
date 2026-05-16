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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check())
        {
            return redirect('login');
        }

        if(auth()->user()->role-> nombre != $role)
        {
            abort(403, 'LOCOTA TRATANDO DE ENTRAR A UNA PAGINA QUE NO LE PERTENECE');
        }

        return $next($request);
    }
}
