<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Categorías
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between px-6 py-4 bg-gray-800 rounded-lg border border-gray-700 shadow-lg">
                <p class="text-sm font-bold text-white">
                    {{ $categorias->total() }} {{ $categorias->total() === 1 ? 'categoría registrada' : 'categorías registradas' }}
                </p>
                <a href="{{ route('categorias.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva categoría
                </a>
            </div>

            <form method="GET" action="{{ route('categorias.index') }}"
                  class="bg-gray-800 rounded-lg border border-gray-700 px-6 py-4">
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Buscar</label>
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="Nombre de la categoría..."
                               class="w-full bg-gray-700 border border-gray-600 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                            Filtrar
                        </button>
                        @if (request()->filled('buscar'))
                            <a href="{{ route('categorias.index') }}"
                               class="bg-gray-600 hover:bg-gray-500 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                @if ($categorias->isEmpty())
                    <div class="text-center py-16 text-white">
                        <p class="text-base font-bold">No hay categorías registradas en el sistema.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-white">Nombre</th>
                                    <th class="px-6 py-4 font-bold text-white">Artículos</th>
                                    <th class="px-6 py-4 font-bold text-white text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($categorias as $categoria)
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-5 font-bold text-white text-base">{{ $categoria->nombre }}</td>
                                        <td class="px-6 py-5 text-gray-400">{{ $categoria->articulos_count }}</td>
                                        <td class="px-6 py-5 text-right whitespace-nowrap space-x-2">
                                            <a href="{{ route('categorias.show', $categoria->id) }}"
                                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                Ver
                                            </a>
                                            <a href="{{ route('categorias.edit', $categoria->id) }}"
                                               class="inline-flex items-center text-xs bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1.5 rounded font-bold transition-colors" style="color: #FFD700">
                                                Editar
                                            </a>
                                            @can('permiso', 'stock.gestionar_categorias')
                                                <form method="POST" action="{{ route('categorias.destroy', $categoria->id) }}"
                                                    class="inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($categorias->hasPages())
                        <div class="px-6 py-4 border-t border-gray-700">
                            {{ $categorias->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
