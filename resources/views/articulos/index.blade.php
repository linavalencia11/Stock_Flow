<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Artículos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between px-6 py-4 bg-gray-800 rounded-lg border border-gray-700 shadow-lg">
                <p class="text-sm font-bold text-white">
                    {{ $articulos->count() }} {{ $articulos->count() === 1 ? 'artículo registrado' : 'artículos registrados' }}
                </p>
                <a href="{{ route('articulos.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo artículo
                </a>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                @if ($articulos->isEmpty())
                    <div class="text-center py-16 text-white">
                        <p class="text-base font-bold">No hay artículos registrados en el sistema.</p>
                    </div>
                @else
                    <form method="GET" action="{{ route('articulos.index') }}" class="mb-6 flex items-center gap-4 bg-gray-800 p-4 rounded-lg border border-gray-700">

                        <div class="flex flex-col gap-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Filtrar por Categoría</label>
                            <select name="categoria_id" class="w-64 h-9 bg-gray-700 border border-gray-600 rounded-lg px-3 text-sm text-black focus:outline-none focus:border-indigo-500">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2 pt-5">
                            <button type="submit" class="h-9 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs px-4 rounded-lg transition-colors whitespace-nowrap">
                                Filtrar
                            </button>

                            @if(request()->filled('categoria_id'))
                                <a href="{{ route('articulos.index') }}" class="h-9 bg-gray-600 hover:bg-gray-500 text-white font-semibold text-xs px-4 rounded-lg transition-colors flex items-center whitespace-nowrap">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-white">Nombre</th>
                                    <th class="px-6 py-4 font-bold text-white">Categoría</th>
                                    <th class="px-6 py-4 font-bold text-white">Estado</th>
                                    <th class="px-6 py-4 font-bold text-white">Ubicación</th>
                                    <th class="px-6 py-4 font-bold text-white text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($articulos as $articulo)
                                    @php
                                        $badgeColor = match($articulo->estado) {
                                            'disponible'    => 'bg-green-100 text-green-800',
                                            'en_prestamo'   => 'bg-yellow-100 text-yellow-800',
                                            'mantenimiento' => 'bg-red-100 text-red-800',
                                            default         => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-5 font-bold text-white text-base">{{ $articulo->nombre }}</td>
                                        <td class="px-6 py-5 text-gray-400">{{ $articulo->categoria->nombre ?? '—' }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $articulo->estado)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-gray-400">{{ $articulo->ubicacion ?? '—' }}</td>
                                        <td class="px-6 py-5 text-right whitespace-nowrap space-x-2">
                                            <a href="{{ route('articulos.show', $articulo->id) }}"
                                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                Ver
                                            </a>
                                            <a href="{{ route('articulos.edit', $articulo->id) }}"
                                               class="inline-flex items-center text-xs bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1.5 rounded font-bold transition-colors" style="color: #FFD700">
                                                Editar
                                            </a>
                                            @if(auth()->user()->rol->nombre === 'Administrador')
                                                <form method="POST" action="{{ route('articulos.destroy', $articulo->id) }}"
                                                    class="inline" onsubmit="return confirm('¿Eliminar este artículo?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center text-xs bg-red-600 hover:bg-red-750 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                         <div class = "mt-4 px-4 py-3 bg-gray-800 rounded-lg border border-gray-700 text-white">
                                    {{ $articulos->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
