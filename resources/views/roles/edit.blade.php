<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Editar rol
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-lg">
                <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
                    <form method="POST" action="{{ route('roles.update', $rol->id) }}" class="space-y-5">
                        @csrf @method('PUT')

                        <div>
                            <label for="nombre" class="block text-sm font-bold mb-2 uppercase tracking-wider" style="color: #ffffff !important;">
                                Nombre
                            </label>

                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $rol->nombre) }}" required
                                   class="w-full rounded-lg px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-400 @enderror"
                                   style="background-color: #374151 !important; border: 1px solid #4b5563 !important; color: #ffffff !important;">

                            @error('nombre')
                                <p class="mt-1 text-xs text-red-400 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2 rounded-lg transition-colors shadow-md">
                                Actualizar
                            </button>
                            <a href="{{ route('roles.index') }}"
                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-bold transition-colors">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
