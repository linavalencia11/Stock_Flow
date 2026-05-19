<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — No encontrado | StockFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="text-center max-w-md px-6">
        <p class="text-9xl font-black text-indigo-500 leading-none mb-4">404</p>
        <h1 class="text-2xl font-bold mb-2">Página no encontrada</h1>
        <p class="text-gray-400 mb-8">
            {{ $message ?? 'El recurso que buscas no existe o fue eliminado.' }}
        </p>
        <div class="flex gap-3 justify-center">
            <a href="javascript:history.back()"
               class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                Volver
            </a>
            @auth
                <a href="{{ route('articulos.index') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                    Ir al inicio
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                    Iniciar sesión
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
