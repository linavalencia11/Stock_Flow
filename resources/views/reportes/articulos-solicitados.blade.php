<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Artículos más solicitados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between px-6 py-4 bg-gray-800 rounded-lg border border-gray-700 shadow-lg">
                <p class="text-sm font-bold text-white">
                    {{ $articulos->total() }} artículos en el inventario
                </p>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                @if ($articulos->isEmpty())
                    <div class="text-center py-16 text-white">
                        <p class="text-base font-bold">No hay artículos registrados.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-white w-12">#</th>
                                    <th class="px-6 py-4 font-bold text-white">Artículo</th>
                                    <th class="px-6 py-4 font-bold text-white">Categoría</th>
                                    <th class="px-6 py-4 font-bold text-white">Estado</th>
                                    <th class="px-6 py-4 font-bold text-white text-center">Total préstamos</th>
                                    <th class="px-6 py-4 font-bold text-white">Popularidad</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @php $maxPrestamos = $articulos->first()->prestamos_count ?: 1; @endphp
                                @foreach ($articulos as $i => $articulo)
                                    @php
                                        $badgeColor = match($articulo->estado) {
                                            'disponible'    => 'bg-green-100 text-green-800',
                                            'en_prestamo'   => 'bg-yellow-100 text-yellow-800',
                                            'mantenimiento' => 'bg-red-100 text-red-800',
                                            default         => 'bg-gray-100 text-gray-600',
                                        };
                                        $pos = $articulos->firstItem() + $i;
                                    @endphp
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 text-gray-400 font-bold">
                                            @if($pos <= 3)
                                                <span class="text-yellow-400">{{ $pos }}</span>
                                            @else
                                                {{ $pos }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-bold text-white">{{ $articulo->nombre }}</td>
                                        <td class="px-6 py-4 text-gray-400">{{ $articulo->categoria->nombre ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $articulo->estado)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-white bg-indigo-600 rounded-full">
                                                {{ $articulo->prestamos_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 w-48">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-700 rounded-full h-2">
                                                    <div class="bg-indigo-500 h-2 rounded-full"
                                                         style="width: {{ $maxPrestamos > 0 ? round(($articulo->prestamos_count / $maxPrestamos) * 100) : 0 }}%">
                                                    </div>
                                                </div>
                                                <span class="text-xs text-gray-400 w-8 text-right">
                                                    {{ $maxPrestamos > 0 ? round(($articulo->prestamos_count / $maxPrestamos) * 100) : 0 }}%
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($articulos->hasPages())
                        <div class="px-6 py-4 border-t border-gray-700">
                            {{ $articulos->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
