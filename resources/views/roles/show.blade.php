<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Detalles del Rol: {{ $rol->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-2xl space-y-6">

                <div class="bg-gray-800 rounded-xl shadow-xl p-6 border border-gray-700">
                    <dl class="space-y-6">
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nombre</dt>
                            <dd class="mt-1 text-base font-bold text-white">{{ $rol->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Usuarios asignados</dt>
                            <dd class="mt-1 text-base font-bold text-white">
                                {{ $rol->usuarios->count() }} usuarios
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Creado</dt>
                            <dd class="mt-1 text-base font-bold text-white">
                                {{ $rol->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6 border-t border-gray-700 pt-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                            Permisos incluidos en este rol ({{ $rol->permisos->count() }})
                        </h3>

                        @if ($rol->permisos->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-48 overflow-y-auto pr-1">
                                @foreach ($rol->permisos as $permiso)
                                    <div class="p-2 rounded-lg bg-gray-900 border border-gray-700/60 flex flex-col justify-center" style = "color:aliceblue">
                                        <span class="text-xs font-bold text-indigo-400 font-mono">{{ $permiso->nombre }}</span>
                                        @if($permiso->descripcion)
                                            <span class="text-[11px] text-gray-400 mt-0.5 line-clamp-1" style = "color:aliceblue">{{ $permiso->descripcion }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Este rol no cuenta con ningún permiso asignado todavía.</p>
                        @endif
                    </div>

                    <div class="mt-6 border-t border-gray-700 pt-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Usuarios con este rol</h3>

                        @if ($rol->usuarios->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach ($rol->usuarios as $usuario)
                                    <li class="text-sm bg-gray-750/40 p-2 rounded-lg border border-gray-700/50 flex justify-between items-center">
                                        <a href="{{ route('usuarios.show', $usuario->id) }}"
                                           class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors" style="color: aliceblue">
                                            {{ $usuario->nombre }}
                                        </a>
                                        <span class="text-white text-xs">{{ $usuario->email }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-gray-400 italic">No hay usuarios vinculados a este rol.</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('roles.edit', $rol->id) }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors shadow-md">
                        Editar
                    </a>

                    <form method="POST" action="{{ route('roles.destroy', $rol->id) }}"
                          onsubmit="return confirm('¿Eliminar este rol?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-750 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors shadow-md">
                            Eliminar
                        </button>
                    </form>

                    <a href="{{ route('roles.index') }}"
                       class="text-sm font-bold text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">
                        Volver
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
