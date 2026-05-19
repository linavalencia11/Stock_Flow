<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ $articulo->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-2xl space-y-6">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        @if ($articulo->foto)
            <img src="{{ Storage::url($articulo->foto) }}" alt="{{ $articulo->nombre }}"
                 class="h-48 w-full object-cover rounded-lg mb-6">
        @endif
        <dl class="space-y-4">
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Nombre</dt>
                <dd class="mt-1 text-sm text-white">{{ $articulo->nombre }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Categoría</dt>
                <dd class="mt-1 text-sm text-white">{{ $articulo->categoria->nombre ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Estado</dt>
                <dd class="mt-1">
                    @php
                        $badgeColor = match($articulo->estado) {
                            'disponible'    => 'bg-green-100 text-green-800',
                            'en_prestamo'   => 'bg-yellow-100 text-yellow-800',
                            'mantenimiento' => 'bg-red-100 text-red-800',
                            default         => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                        {{ ucfirst(str_replace('_', ' ', $articulo->estado)) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Ubicación</dt>
                <dd class="mt-1 text-sm text-white">{{ $articulo->ubicacion ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Activo</dt>
                <dd class="mt-1 text-sm text-white">{{ $articulo->activo ? 'Sí' : 'No' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Registrado</dt>
                <dd class="mt-1 text-sm text-white">{{ $articulo->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
            </div>
        </dl>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('articulos.edit', $articulo->id) }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            Editar
        </a>
        @if(auth()->user()->rol->nombre === 'Administrador')
            <form method="POST" action="{{ route('articulos.destroy', $articulo->id) }}"
                onsubmit="return confirm('¿Eliminar este artículo?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                    Eliminar
                </button>
            </form>
        @endif
        <a href="{{ route('articulos.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Volver</a>
    </div>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
