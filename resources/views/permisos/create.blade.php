<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Nuevo permiso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="max-w-lg">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        <form method="POST" action="{{ route('permisos.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-400 @enderror">
                @error('nombre') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                          class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none
                                 focus:ring-2 focus:ring-indigo-500 @error('descripcion') border-red-400 @enderror"
                          placeholder="Ej: Permite la creación y modificación de usuarios del sistema...">{{ old('descripcion') }}</textarea>
                @error('descripcion') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                    Guardar
                </button>
                <a href="{{ route('permisos.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
