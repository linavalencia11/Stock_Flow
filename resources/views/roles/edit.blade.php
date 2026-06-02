<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Editar rol: {{ $rol->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-lg">
                <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
                    <form method="POST" action="{{ route('roles.update', $rol->id) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

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

                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-sm font-bold uppercase tracking-wider" style="color: #ffffff !important;">
                                    Permisos Asignados
                                </label>
                                <span id="contador-permisos" class="text-xs text-gray-400 bg-gray-900 px-2 py-1 rounded-md border border-gray-700">
                                    0 seleccionados
                                </span>
                            </div>

                            @if($todosLosPermisos->isNotEmpty())
                                <div class="mb-3 relative">
                                    <input type="text" id="buscar-permiso"
                                           placeholder="Filtrar permisos por nombre o descripción..."
                                           class="w-full rounded-lg pl-9 pr-3 py-2 text-xs text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                           style="background-color: #1f2937 !important; border: 1px solid #374151 !important;">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>

                                <div id="lista-permisos" class="space-y-2 max-h-64 overflow-y-auto pr-2 border border-gray-750 p-2 rounded-xl bg-gray-900/50">
                                    @foreach($todosLosPermisos as $permiso)
                                        @php
                                            // Evaluamos si el permiso debe estar marcado (si viene de old() por error de validación, o si ya existía en la relación del rol)
                                            $isChecked = false;
                                            if (is_array(old('permisos'))) {
                                                $isChecked = in_array($permiso->id, old('permisos'));
                                            } else {
                                                $isChecked = $rol->permisos->contains($permiso->id);
                                            }
                                        @endphp

                                        <label class="item-permiso flex items-start gap-3 bg-gray-900 border border-gray-700 p-3 rounded-lg cursor-pointer hover:bg-gray-850 transition-colors"
                                               data-nombre="{{ strtolower($permiso->nombre) }}"
                                               data-descripcion="{{ strtolower($permiso->descripcion) }}">

                                            <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                                   {{ $isChecked ? 'checked' : '' }}
                                                   class="chk-permiso mt-1 rounded border-gray-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-900 bg-gray-800">

                                            <div class="text-sm">
                                                <span class="font-semibold text-white block nombre-texto">{{ $permiso->nombre }}</span>
                                                @if($permiso->descripcion)
                                                    <span class="text-xs text-gray-400 descripcion-texto">{{ $permiso->descripcion }}</span>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach

                                    <p id="sin-resultados" class="hidden text-sm text-gray-500 italic text-center py-4">
                                        No se encontraron permisos que coincidan con la búsqueda.
                                    </p>
                                </div>
                            @else
                                <p class="text-sm text-gray-400 italic">No hay permisos registrados en el sistema todavía.</p>
                            @endif

                            @error('permisos')
                                <p class="mt-1 text-xs text-red-400 font-semibold" style = "color:aliceblue">{{ $message }}</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buscador = document.getElementById('buscar-permiso');
            const items = document.querySelectorAll('.item-permiso');
            const sinResultados = document.getElementById('sin-resultados');
            const checkboxes = document.querySelectorAll('.chk-permiso');
            const contador = document.getElementById('contador-permisos');

            // 1. Buscador en tiempo real
            if (buscador) {
                buscador.addEventListener('input', function (e) {
                    const termino = e.target.value.toLowerCase().trim();
                    let coincidencias = 0;

                    items.forEach(item => {
                        const nombre = item.getAttribute('data-nombre');
                        const descripcion = item.getAttribute('data-descripcion');

                        if (nombre.includes(termino) || descripcion.includes(termino)) {
                            item.style.setProperty('display', 'flex', 'important');
                            coincidencias++;
                        } else {
                            item.style.setProperty('display', 'none', 'important');
                        }
                    });

                    if (coincidencias === 0 && termino !== '') {
                        sinResultados.classList.remove('hidden');
                    } else {
                        sinResultados.classList.add('hidden');
                    }
                });
            }

            // 2. Contador de seleccionados
            function actualizarContador() {
                const seleccionados = Array.from(checkboxes).filter(chk => chk.checked).length;
                contador.textContent = `${seleccionados} seleccionado${seleccionados !== 1 ? 's' : ''}`;
            }

            checkboxes.forEach(chk => {
                chk.addEventListener('change', actualizarContador);
            });

            // Forzar actualización inicial para contar los permisos que ya trae el rol
            actualizarContador();
        });
    </script>
</x-app-layout>
