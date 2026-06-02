{{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="px-6 py-6 border-b border-gray-700 text-center">
            <a href="{{ route('dashboard') }}" class="inline-block">
                <span class="text-xl font-bold tracking-wide text-white hover:text-indigo-300">StockFlow</span>
                <p class="text-xs text-gray-400 mt-0.5">Gestión de inventario</p>
            </a>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @php
                $nav = [
                    ['route' => 'articulos.index',   'label' => 'Artículos',     'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'permiso' => 'catalogo.ver_lista'],
                    ['route' => 'categorias.index',  'label' => 'Categorías',    'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'permiso' => 'stock.gestionar_categorias'],
                    ['route' => 'prestamos.index',   'label' => 'Préstamos',     'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'permiso' => 'prestamos.ver_todos_activos'],
                    ['route' => 'usuarios.index',    'label' => 'Usuarios',      'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'permiso' => 'administracion.registrar_usuarios'],
                    ['route' => 'roles.index',       'label' => 'Roles',         'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'permiso' => 'administracion.editar_usuarios_roles'],
                    ['route' => 'prestamos.usuario', 'label' => 'Mis Préstamos', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'permiso' => 'reportes.ver_mis_prestamos'],
                ];
            @endphp

            @foreach ($nav as $item)
                @can('permiso', $item['permiso'])
                    @php $active = request()->routeIs(Str::before($item['route'], '.') . '.*'); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ $active ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                    </a>
                @endcan
            @endforeach
        </nav>
    </aside>
