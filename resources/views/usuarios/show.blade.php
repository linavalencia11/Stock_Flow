<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ $usuario->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-2xl space-y-6">

                <!-- Tarjeta de Detalles -->
                <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">ID / Cédula</dt>
                            <dd class="mt-1 text-base font-bold text-white">{{ $usuario->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nombre</dt>
                            <dd class="mt-1 text-base font-bold text-white">{{ $usuario->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Email</dt>
                            <dd class="mt-1 text-sm text-gray-300">{{ $usuario->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Contacto</dt>
                            <dd class="mt-1 text-sm text-gray-300">{{ $usuario->contacto ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rol</dt>
                            <dd class="mt-1 text-sm text-gray-300">{{ $usuario->rol->nombre ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</dt>
                            <dd class="mt-1">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold
                                    {{ $usuario->activo ? 'bg-green-100 text-green-800' : 'bg-gray-600 text-white' }}">
                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Registrado</dt>
                            <dd class="mt-1 text-sm text-gray-300">{{ $usuario->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center gap-3 whitespace-nowrap">

                    <a href="{{ route('usuarios.index') }}"
                       class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-bold transition-colors">
                        Volver
                    </a>

                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                       class="inline-flex items-center text-xs bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-lg font-bold transition-colors" style="color: #FFD700">
                        Editar
                    </a>

                    @if ($usuario->id !== Auth::id())
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}"
                              class="inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center text-xs bg-red-600 hover:bg-red-750 text-white px-4 py-2 rounded-lg font-bold transition-colors">
                                Eliminar
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
