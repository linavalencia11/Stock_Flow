<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            Actualizar préstamo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<div class="max-w-xl">

    {{-- Info del préstamo --}}
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6 text-sm text-gray-600 space-y-1">
        <p><span class="font-medium text-gray-800">Artículo:</span> {{ $prestamo->articulos->nombre ?? '—' }}</p>
        <p><span class="font-medium text-gray-800">Solicitante:</span> {{ $prestamo->solicitante->nombre ?? '—' }}</p>
        <p><span class="font-medium text-gray-800">Solicitud:</span> {{ $prestamo->fecha_solicitud?->format('d/m/Y H:i') ?? '—' }}</p>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700">
        <form method="POST" action="{{ route('prestamos.update', $prestamo->id) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" name="estado" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('estado') border-red-400 @enderror">
                    @foreach ($estados as $est)
                        <option value="{{ $est }}" {{ old('estado', $prestamo->estado) == $est ? 'selected' : '' }}>
                            {{ ucfirst($est) }}
                        </option>
                    @endforeach
                </select>
                @error('estado') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="custodio_id" class="block text-sm font-medium text-gray-700 mb-1">Custodio</label>
                <select id="custodio_id" name="custodio_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('custodio_id') border-red-400 @enderror">
                    @foreach ($custodios as $custodio)
                        <option value="{{ $custodio->id }}"
                            {{ old('custodio_id', $prestamo->custodio_id) == $custodio->id ? 'selected' : '' }}>
                            {{ $custodio->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('custodio_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 mb-1">Fecha de entrega</label>
                <input type="datetime-local" id="fecha_entrega" name="fecha_entrega"
                       value="{{ old('fecha_entrega', $prestamo->fecha_entrega?->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('fecha_entrega') border-red-400 @enderror">
                @error('fecha_entrega') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fecha_limite" class="block text-sm font-medium text-gray-700 mb-1">Fecha límite</label>
                <input type="date" id="fecha_limite" name="fecha_limite"
                       value="{{ old('fecha_limite', $prestamo->fecha_limite?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('fecha_limite') border-red-400 @enderror">
                @error('fecha_limite') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fecha_devolucion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de devolución</label>
                <input type="datetime-local" id="fecha_devolucion" name="fecha_devolucion"
                       value="{{ old('fecha_devolucion', $prestamo->fecha_devolucion?->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                              focus:ring-2 focus:ring-indigo-500 @error('fecha_devolucion') border-red-400 @enderror">
                @error('fecha_devolucion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="estado_devolucion" class="block text-sm font-medium text-gray-700 mb-1">Estado de devolución</label>
                <select id="estado_devolucion" name="estado_devolucion"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none
                               focus:ring-2 focus:ring-indigo-500 @error('estado_devolucion') border-red-400 @enderror">
                    <option value="">— Sin registrar —</option>
                    @foreach ($estadosDevolucion as $ed)
                        <option value="{{ $ed }}"
                            {{ old('estado_devolucion', $prestamo->estado_devolucion) == $ed ? 'selected' : '' }}>
                            {{ ucfirst($ed) }}
                        </option>
                    @endforeach
                </select>
                @error('estado_devolucion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                    Actualizar
                </button>
                <a href="{{ route('prestamos.show', $prestamo->id) }}" class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
</x-app-layout>
