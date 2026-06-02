<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
        Route::middleware('web')
            ->group(base_path('routes/inventario.php'));
        Route::middleware('web')
            ->group(base_path('routes/prestamos.php'));
        Route::middleware('web')
            ->group(base_path('routes/usuarios.php'));
    },
    )
    ->withMiddleware(function (Middleware $middleware)  {
        $middleware->alias([
            'role' => App\Http\Middleware\CheckRole::class,
            'permission' => App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (
            \Illuminate\Database\Eloquent\ModelNotFoundException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Recurso no encontrado.'], 404);
            }
            return response()->view('errors.404', [
                'message' => 'El recurso que buscas no existe o fue eliminado.',
            ], 404);
        });

        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Página no encontrada.'], 404);
            }
            return response()->view('errors.404', [
                'message' => 'La página que buscas no existe.',
            ], 404);
        });

        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acceso denegado.'], 403);
            }
            return response()->view('errors.403', [], 403);
        });
    })->create();
