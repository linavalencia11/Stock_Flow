<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Nuevo usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-xl">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        <form method="POST" action="{{ route('usuarios.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="id" class="block text-sm font-medium text-white mb-1">ID / Cédula</label>
                <input type="text" id="id" name="id" value="{{ old('id') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('id') border-red-400 @enderror">
                @error('id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="nombre" class="block text-sm font-medium text-white mb-1">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-400 @enderror">
                @error('nombre') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-white mb-1">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('email') border-red-400 @enderror">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contacto" class="block text-sm font-medium text-white mb-1">Contacto (opcional)</label>
                <input type="text" id="contacto" name="contacto" value="{{ old('contacto') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('contacto') border-red-400 @enderror">
                @error('contacto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="rol_id" class="block text-sm font-medium text-white mb-1">Rol</label>
                <select id="rol_id" name="rol_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('rol_id') border-red-400 @enderror">
                    <option value="">Seleccionar rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('rol_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-white mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('password') border-red-400 @enderror">
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                    Guardar
                </button>
                <a href="{{ route('usuarios.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
