<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Editar artículo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-xl">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        <form method="POST" action="{{ route('articulos.update', $articulo->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-200 mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $articulo->nombre) }}" required
                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-100 placeholder-gray-400 focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-400 @enderror">
                @error('nombre') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select id="categoria_id" name="categoria_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('categoria_id') border-red-400 @enderror">
                    <option value="">Seleccionar categoría</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categoria_id', $articulo->categoria_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" name="estado" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('estado') border-red-400 @enderror">
                    @foreach (['disponible', 'en_prestamo', 'mantenimiento'] as $estado)
                        <option value="{{ $estado }}"
                            {{ old('estado', $articulo->estado) == $estado ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $estado)) }}
                        </option>
                    @endforeach
                </select>
                @error('estado') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $articulo->ubicacion) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('ubicacion') border-red-400 @enderror">
                @error('ubicacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                @if ($articulo->foto)
                    <img src="{{ Storage::url($articulo->foto) }}" alt="Foto actual" class="h-24 w-24 object-cover rounded-lg mb-2">
                    <p class="text-xs text-gray-400 mb-2">Sube una nueva imagen para reemplazar la actual.</p>
                @endif
                <input type="file" id="foto" name="foto" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg
                              file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100 @error('foto') border-red-400 @enderror">
                @error('foto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                    Actualizar
                </button>
                <a href="{{ route('articulos.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
