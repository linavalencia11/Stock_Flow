<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Reporte general de préstamos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjetas por estado --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $estados = [
                        'pendiente'  => ['label' => 'Pendientes',  'color' => 'border-yellow-600 text-yellow-400'],
                        'aprobado'   => ['label' => 'Aprobados',   'color' => 'border-blue-600   text-blue-400'],
                        'entregado'  => ['label' => 'Entregados',  'color' => 'border-orange-600 text-orange-400'],
                        'devuelto'   => ['label' => 'Devueltos',   'color' => 'border-green-600  text-green-400'],
                        'rechazado'  => ['label' => 'Rechazados',  'color' => 'border-red-700    text-red-400'],
                        'cancelado'  => ['label' => 'Cancelados',  'color' => 'border-gray-600   text-gray-400'],
                    ];
                @endphp

                @foreach ($estados as $key => $cfg)
                    <div class="bg-gray-800 rounded-lg border {{ $cfg['color'] }} px-5 py-4">
                        <p class="text-xs font-bold {{ $cfg['color'] }} uppercase tracking-wider mb-1">{{ $cfg['label'] }}</p>
                        <p class="text-3xl font-black text-white">{{ $porEstado[$key] ?? 0 }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Total + préstamos por mes --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gray-800 rounded-lg border border-gray-700 px-6 py-5">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Total histórico</p>
                    <p class="text-6xl font-black text-indigo-400">{{ $totalPrestamos }}</p>
                    <p class="text-sm text-gray-400 mt-2">préstamos registrados</p>
                </div>

                <div class="bg-gray-800 rounded-lg border border-gray-700 px-6 py-5">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Últimos 6 meses</p>
                    @if ($porMes->isEmpty())
                        <p class="text-sm text-gray-500">Sin datos en este período.</p>
                    @else
                        <div class="space-y-2">
                            @foreach ($porMes as $mes => $total)
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-400 w-16">{{ $mes }}</span>
                                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                                        <div class="bg-indigo-500 h-3 rounded-full"
                                             style="width: {{ $porMes->max() > 0 ? round(($total / $porMes->max()) * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-white w-6 text-right">{{ $total }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Préstamos recientes --}}
            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Préstamos recientes</h3>
                </div>
                @if ($prestamosRecientes->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <p class="text-sm">No hay préstamos registrados.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-white">Artículo</th>
                                    <th class="px-6 py-3 font-bold text-white">Solicitante</th>
                                    <th class="px-6 py-3 font-bold text-white">Custodio</th>
                                    <th class="px-6 py-3 font-bold text-white">Estado</th>
                                    <th class="px-6 py-3 font-bold text-white">Fecha</th>
                                    <th class="px-6 py-3 font-bold text-white text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($prestamosRecientes as $prestamo)
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
                                        <td class="px-6 py-4 text-gray-400">{{ $prestamo->solicitante->nombre ?? '—' }}</td>
                                        <td class="px-6 py-4 text-gray-400">{{ $prestamo->custodio->nombre ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeColor }}">
                                                {{ ucfirst($prestamo->estado) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-400">{{ $prestamo->created_at?->format('d/m/Y') ?? '—' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('prestamos.show', $prestamo->id) }}"
                                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                Ver
                                            </a>
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
