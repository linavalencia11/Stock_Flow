<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Nuevo préstamo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-xl">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        <form method="POST" action="{{ route('prestamos.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="articulo_id" class="block text-sm font-medium text-gray-700 mb-1">Artículo</label>
                <select id="articulo_id" name="articulo_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('articulo_id') border-red-400 @enderror">
                    <option value="">Seleccionar artículo disponible</option>
                    @foreach ($articulos as $articulo)
                        <option value="{{ $articulo->id }}" {{ old('articulo_id') == $articulo->id ? 'selected' : '' }}>
                            {{ $articulo->nombre }} — {{ $articulo->categoria->nombre ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('articulo_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                @if ($articulos->isEmpty())
                    <p class="mt-1 text-xs text-orange-500">No hay artículos disponibles en este momento.</p>
                @endif
            </div>

            <div>
                <label for="solicitante_id" class="block text-sm font-medium text-gray-700 mb-1">Solicitante</label>
                <select id="solicitante_id" name="solicitante_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('solicitante_id') border-red-400 @enderror">
                    <option value="">Seleccionar solicitante</option>
                    @foreach ($solicitantes as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('solicitante_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nombre }} ({{ $usuario->rol->nombre ?? '' }})
                        </option>
                    @endforeach
                </select>
                @error('solicitante_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="custodio_id" class="block text-sm font-medium text-gray-700 mb-1">Custodio</label>
                <select id="custodio_id" name="custodio_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('custodio_id') border-red-400 @enderror">
                    <option value="">Seleccionar custodio</option>
                    @foreach ($custodios as $custodio)
                        <option value="{{ $custodio->id }}" {{ old('custodio_id') == $custodio->id ? 'selected' : '' }}>
                            {{ $custodio->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('custodio_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fecha_limite" class="block text-sm font-medium text-gray-700 mb-1">Fecha límite de devolución</label>
                <input type="date" id="fecha_limite" name="fecha_limite"
                       value="{{ old('fecha_limite') }}" required
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('fecha_limite') border-red-400 @enderror">
                @error('fecha_limite') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                    Crear solicitud
                </button>
                <a href="{{ route('prestamos.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
