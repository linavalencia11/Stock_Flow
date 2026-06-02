<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Detalles del Permiso: {{ $permiso->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-2xl space-y-6">

                <div class="bg-gray-800 rounded-xl shadow-xl p-6 border border-gray-700">
                    <dl class="space-y-6">
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nombre</dt>
                            <dd class="mt-1 text-base font-bold text-white">{{ $permiso->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</dt>
                            <dd class="mt-1 text-base font-bold text-white">
                                {{ $permiso->descripcion ?? 'Sin descripción disponible.' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Creado</dt>
                            <dd class="mt-1 text-base font-bold text-white">
                                {{ $permiso->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    @if ($permiso->roles->isNotEmpty())
                        <div class="mt-6 border-t border-gray-700 pt-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Roles que incluyen este permiso</h3>
                            <ul class="space-y-2">
                                @foreach ($permiso->roles as $rol)
                                    <li class="text-sm bg-gray-750/40 p-3 rounded-lg border border-gray-700/50 flex justify-between items-center">
                                        <a href="{{ route('roles.show', $rol->id) }}"
                                           class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors" style="color: aliceblue">
                                            {{ $rol->nombre }}
                                        </a>
                                        <span class="text-gray-400 text-xs uppercase tracking-wider">Rol del Sistema</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="mt-6 border-t border-gray-700 pt-4">
                            <p class="text-sm text-gray-400 italic">Este permiso no está asignado a ningún rol todavía.</p>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('permisos.edit', $permiso->id) }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors shadow-md">
                        Editar
                    </a>

                    <form method="POST" action="{{ route('permisos.destroy', $permiso->id) }}"
                          onsubmit="return confirm('¿Eliminar este permiso?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors shadow-md">
                            Eliminar
                        </button>
                    </form>

                    <a href="{{ route('permisos.index') }}"
                       class="text-sm font-bold text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">
                        Volver
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
