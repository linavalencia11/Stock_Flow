<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Préstamos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between px-6 py-4 bg-gray-800 rounded-lg border border-gray-700 shadow-lg">
                <p class="text-sm font-bold text-white">
                    {{ $prestamos->count() }} {{ $prestamos->count() === 1 ? 'préstamo registrado' : 'préstamos registrados' }}
                </p>
                <a href="{{ route('prestamos.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo préstamo
                </a>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                @if ($prestamos->isEmpty())
                    <div class="text-center py-16 text-white">
                        <p class="text-base font-bold">No hay préstamos registrados en el sistema.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-white">Artículo</th>
                                    <th class="px-6 py-4 font-bold text-white">Solicitante</th>
                                    <th class="px-6 py-4 font-bold text-white">Custodio</th>
                                    <th class="px-6 py-4 font-bold text-white">Estado</th>
                                    <th class="px-6 py-4 font-bold text-white">Fecha límite</th>
                                    <th class="px-6 py-4 font-bold text-white text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($prestamos as $prestamo)
                                    @php
                                        $badgeColor = match($prestamo->estado) {
                                            'pendiente'  => 'bg-yellow-100 text-yellow-800',
                                            'aprobado'   => 'bg-blue-100 text-blue-800',
                                            'entregado'  => 'bg-orange-100 text-orange-800',
                                            'devuelto'   => 'bg-green-100 text-green-800',
                                            'rechazado'  => 'bg-red-100 text-red-800',
                                            'cancelado'  => 'bg-gray-100 text-gray-500',
                                            default      => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-5 font-bold text-white text-base">{{ $prestamo->articulos->nombre ?? '—' }}</td>
                                        <td class="px-6 py-5 text-gray-400">{{ $prestamo->solicitante->nombre ?? '—' }}</td>
                                        <td class="px-6 py-5 text-gray-400">{{ $prestamo->custodio->nombre ?? '—' }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeColor }}">
                                                {{ ucfirst($prestamo->estado) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-gray-400">{{ $prestamo->fecha_limite ? $prestamo->fecha_limite->format('d/m/Y') : '—' }}</td>
                                        <td class="px-6 py-5 text-right whitespace-nowrap space-x-2">
                                            <a href="{{ route('prestamos.show', $prestamo->id) }}"
                                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                Ver
                                            </a>
                                            @if(in_array(auth()->user()->rol->nombre, ['Administrador', 'Custodio']))
                                                @if (!in_array($prestamo->estado, ['devuelto', 'rechazado', 'cancelado']))
                                                    <a href="{{ route('prestamos.edit', $prestamo->id) }}"
                                                    class="inline-flex items-center text-xs bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1.5 rounded font-bold transition-colors" style="color: #FFD700">
                                                        Editar
                                                    </a>
                                                @endif
                                                    @if(auth()->user()->rol->nombre === 'Administrador')
                                                        @if (!in_array($prestamo->estado, ['entregado']))
                                                            <form method="POST" action="{{ route('prestamos.destroy', $prestamo->id) }}"
                                                                class="inline" onsubmit="return confirm('¿Eliminar este préstamo?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                        class="inline-flex items-center text-xs bg-red-600 hover:bg-red-750 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
