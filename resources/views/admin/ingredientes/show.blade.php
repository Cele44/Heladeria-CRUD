<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles del Ingrediente: {{ $ingrediente->nombre }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Info izquierda --}}
            <div class="space-y-2">
                <p><span class="font-semibold text-gray-700">ID:</span> {{ $ingrediente->id }}</p>
                <p><span class="font-semibold text-gray-700">Nombre:</span> {{ $ingrediente->nombre }}</p>
                <p><span class="font-semibold text-gray-700">Tipo:</span> {{ ucfirst($ingrediente->tipo) }}</p>
                <p><span class="font-semibold text-gray-700">Precio Extra:</span> ${{ number_format($ingrediente->precio_extra, 2) }}</p>
                <p>
                    <div class="flex items-center">
                        <label for="activo" class="block text-sm font-medium text-gray-700 mr-4">Estado:</label>
                        <label for="activo" class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="activo" value="0">
                            <input type="checkbox" id="activo" name="activo" value="1" class="sr-only peer" {{ old('activo', $ingrediente->disponible) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer dark:bg-gray-700 peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
                        </label>
                    </div>
                </p>
            </div>

            {{-- Imagen + Descripción --}}
            <div>
                @if($ingrediente->imagen_url)
                    <img src="{{ asset('' . $ingrediente->imagen_url) }}" alt="{{ $ingrediente->nombre }}"
                         class="rounded-md object-cover w-full max-h-52">
                @endif
                <div class="mt-4">
                    <p class="font-semibold text-gray-700">Descripción:</p>
                    <p class="text-gray-600 mt-1">{{ $ingrediente->descripcion ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <a href="{{ route('admin.ingredientes.edit', $ingrediente) }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Editar
            </a>
            <a href="{{ route('admin.ingredientes.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded hover:bg-gray-400">
                Volver
            </a>
        </div>
    </div>
</div>