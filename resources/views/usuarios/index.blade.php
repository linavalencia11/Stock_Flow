<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between px-6 py-4 bg-gray-800 rounded-lg border border-gray-700 shadow-lg">
                <p class="text-sm font-bold text-white">
                    {{ $usuarios->total() }} {{ $usuarios->total() === 1 ? 'usuario registrado' : 'usuarios registrados' }}
                </p>
                <a href="{{ route('usuarios.create') }}"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo usuario
                </a>
            </div>

            <form method="GET" action="{{ route('usuarios.index') }}"
                  class="bg-gray-800 rounded-lg border border-gray-700 px-6 py-4">
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Buscar</label>
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="Nombre o correo..."
                               class="w-full bg-gray-700 border border-gray-600 text-black text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-500">
                    </div>
                    <div class="min-w-[150px]">
                        <label class="block text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Rol</label>
                        <select name="rol_id"
                                class="w-full bg-gray-700 border border-gray-600 text-black text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}" {{ request('rol_id') == $rol->id ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="min-w-[130px]">
                        <label class="block text-xs font-bold text-gray-400 mb-1 uppercase tracking-wider">Estado</label>
                        <select name="activo"
                                class="w-full bg-gray-700 border border-gray-600 text-black text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                            Filtrar
                        </button>
                        @if (request()->hasAny(['buscar', 'rol_id', 'activo']))
                            <a href="{{ route('usuarios.index') }}"
                               class="bg-gray-600 hover:bg-gray-500 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                @if ($usuarios->isEmpty())
                    <div class="text-center py-16 text-white">
                        <p class="text-base font-bold">No hay usuarios registrados en el sistema.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-700 text-white text-xs uppercase tracking-wider border-b border-gray-600">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-white">Nombre</th>
                                    <th class="px-6 py-4 font-bold text-white">Email</th>
                                    <th class="px-6 py-4 font-bold text-white">Rol</th>
                                    <th class="px-6 py-4 font-bold text-white">Estado</th>
                                    <th class="px-6 py-4 font-bold text-white text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($usuarios as $usuario)
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-5 font-bold text-white text-base">{{ $usuario->nombre }}</td>
                                        <td class="px-6 py-5 text-gray-400">{{ $usuario->email }}</td>
                                        <td class="px-6 py-5 text-gray-400">{{ $usuario->rol->nombre ?? '—' }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold
                                                {{ $usuario->activo ? 'bg-green-100 text-green-800' : 'bg-gray-600 text-white' }}">
                                                {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right whitespace-nowrap space-x-2">
                                            <a href="{{ route('usuarios.show', $usuario->id) }}"
                                               class="inline-flex items-center text-xs bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                Ver
                                            </a>
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                               class="inline-flex items-center text-xs bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1.5 rounded font-bold transition-colors" style="color: #FFD700">
                                                Editar
                                            </a>
                                            @if ($usuario->id !== Auth::id())
                                                <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}"
                                                      class="inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded font-bold transition-colors">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($usuarios->hasPages())
                        <div class="px-6 py-4 border-t border-gray-700">
                            {{ $usuarios->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
