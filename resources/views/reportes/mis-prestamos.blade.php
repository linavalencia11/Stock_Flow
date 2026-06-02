<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            @if($rol === 'Solicitante') Mis préstamos realizados
            @elseif($rol === 'Custodio') Préstamos bajo mi custodia
            @else Todos los préstamos
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjetas de resumen --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-800 rounded-lg border border-gray-700 px-5 py-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total</p>
                    <p class="text-3xl font-black text-white">{{ $resumen['total'] }}</p>
                </div>
                <div class="bg-gray-800 rounded-lg border border-yellow-700 px-5 py-4">
                    <p class="text-xs font-bold text-yellow-400 uppercase tracking-wider mb-1">Activos</p>
                    <p class="text-3xl font-black text-white">{{ $resumen['activos'] }}</p>
                </div>
                <div class="bg-gray-800 rounded-lg border border-green-700 px-5 py-4">
                    <p class="text-xs font-bold text-green-400 uppercase tracking-wider mb-1">Devueltos</p>
                    <p class="text-3xl font-black text-white">{{ $resumen['devueltos'] }}</p>
                </div>
                <div class="bg-gray-800 rounded-lg border border-red-800 px-5 py-4">
                    <p class="text-xs font-bold text-red-400 uppercase tracking-wider mb-1">Cancelados / Rechazados</p>
                    <p class="text-3xl font-black text-white">{{ $resumen['cancelados'] }}</p>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                @if ($prestamos->isEmpty())
                    <div class="text-center py-16 text-white">
                        <p class="text-base font-bold">No hay préstamos registrados.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-white">Artículo</th>
                                    @if($rol !== 'Solicitante')
                                        <th class="px-6 py-4 font-bold text-white">Solicitante</th>
                                    @endif
                                    @if($rol !== 'Custodio')
                                        <th class="px-6 py-4 font-bold text-white">Custodio</th>
                                    @endif
                                    <th class="px-6 py-4 font-bold text-white">Estado</th>
                                    <th class="px-6 py-4 font-bold text-white">Fecha límite</th>
                                    <th class="px-6 py-4 font-bold text-white">Devolución</th>
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
                                        <td class="px-6 py-4 font-bold text-white">{{ $prestamo->articulos->nombre ?? '—' }}</td>
                                        @if($rol !== 'Solicitante')
                                            <td class="px-6 py-4 text-gray-400">{{ $prestamo->solicitante->nombre ?? '—' }}</td>
                                        @endif
                                        @if($rol !== 'Custodio')
                                            <td class="px-6 py-4 text-gray-400">{{ $prestamo->custodio->nombre ?? '—' }}</td>
                                        @endif
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeColor }}">
                                                {{ ucfirst($prestamo->estado) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-400">{{ $prestamo->fecha_limite?->format('d/m/Y') ?? '—' }}</td>
                                        <td class="px-6 py-4 text-gray-400">{{ $prestamo->fecha_devolucion?->format('d/m/Y') ?? '—' }}</td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                            <a href="{{ route('prestamos.show', $prestamo->id) }}"
                                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                Ver
                                            </a>
                                            @can('permiso', 'prestamos.cancelar_solicitud_propia')
                                                @if ($prestamo->estado === 'pendiente')
                                                    <form method="POST" action="{{ route('prestamos.cancelar', $prestamo->id) }}"
                                                          class="inline" onsubmit="return confirm('¿Cancelar esta solicitud?')">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                                class="inline-flex items-center text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
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
