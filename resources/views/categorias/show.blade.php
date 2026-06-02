<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ $categoria->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-2xl space-y-6">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        <dl class="space-y-4">
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Nombre</dt>
                <dd class="mt-1 text-sm text-white ">{{ $categoria->nombre }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Artículos asociados</dt>
                <dd class="mt-1 text-sm text-white">{{ $categoria->articulos()->count() }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-white uppercase tracking-wider">Creada</dt>
                <dd class="mt-1 text-sm text-white">{{ $categoria->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
            </div>
        </dl>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('categorias.edit', $categoria->id) }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            Editar
        </a>
        @can('permiso', 'stock.gestionar_categorias')
            <form method="POST" action="{{ route('categorias.destroy', $categoria->id) }}"
                onsubmit="return confirm('¿Eliminar esta categoría?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                    Eliminar
                </button>
            </form>
        @endcan
        <a href="{{ route('categorias.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Volver</a>
    </div>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
