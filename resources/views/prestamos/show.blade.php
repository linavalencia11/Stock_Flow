<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Préstamo #{{ substr($prestamo->id, 0, 8) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-2xl space-y-6">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
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

        <div class="flex items-center justify-between mb-6">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                {{ ucfirst($prestamo->estado) }}
            </span>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Artículo</dt>
                <dd class="mt-1 text-sm text-gray-100">
                    <a href="{{ route('articulos.show', $prestamo->articulos->id) }}"
                       class="text-indigo-400 hover:text-indigo-300 underline">
                        {{ $prestamo->articulos->nombre ?? '—' }}
                    </a>
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</dt>
                <dd class="mt-1 text-sm text-gray-100">{{ $prestamo->solicitante->nombre ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Custodio</dt>
                <dd class="mt-1 text-sm text-gray-100">{{ $prestamo->custodio->nombre ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha solicitud</dt>
                <dd class="mt-1 text-sm text-gray-100">
                    {{ $prestamo->fecha_solicitud?->format('d/m/Y H:i') ?? '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha entrega</dt>
                <dd class="mt-1 text-sm text-gray-100">
                    {{ $prestamo->fecha_entrega?->format('d/m/Y H:i') ?? '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha límite</dt>
                <dd class="mt-1 text-sm text-gray-100">
                    {{ $prestamo->fecha_limite?->format('d/m/Y') ?? '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha devolución</dt>
                <dd class="mt-1 text-sm text-gray-100">
                    {{ $prestamo->fecha_devolucion?->format('d/m/Y H:i') ?? '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Estado devolución</dt>
                <dd class="mt-1 text-sm text-gray-100">
                    {{ $prestamo->estado_devolucion ? ucfirst($prestamo->estado_devolucion) : '—' }}
                </dd>
            </div>
        </dl>
    </div>

    <div class="flex items-center gap-3">
        @if (!in_array($prestamo->estado, ['devuelto', 'rechazado', 'cancelado']))
            <a href="{{ route('prestamos.edit', $prestamo->id) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                Actualizar estado
            </a>
        @endif
        @if (!in_array($prestamo->estado, ['entregado']))
            <form method="POST" action="{{ route('prestamos.destroy', $prestamo->id) }}"
                  onsubmit="return confirm('¿Eliminar este préstamo?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                    Eliminar
                </button>
            </form>
        @endif
        <a href="{{ route('prestamos.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Volver</a>
    </div>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
