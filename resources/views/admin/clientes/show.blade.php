{{-- admin/clientes/show.blade.php --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles del Cliente: {{ $cliente->nombre }} {{ $cliente->apellido }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Info izquierda --}}
            <div class="space-y-2">
                <p><span class="font-semibold text-gray-700">ID:</span> {{ $cliente->id }}</p>
                <p><span class="font-semibold text-gray-700">Nombre:</span> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                <p><span class="font-semibold text-gray-700">Email:</span> {{ $cliente->email }}</p>
                <p><span class="font-semibold text-gray-700">Teléfono:</span> {{ $cliente->telefono ?? 'N/A' }}</p>
                <p><span class="font-semibold text-gray-700">Dirección:</span> {{ $cliente->direccion ?? 'N/A' }}</p>
                <p><span class="font-semibold text-gray-700">Registro:</span> {{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}</p>
                <p><span class="font-semibold text-gray-700">Último login:</span> {{ $cliente->ultimo_login ? \Carbon\Carbon::parse($cliente->ultimo_login)->format('d/m/Y H:i') : 'Nunca' }}</p>
            </div>

            {{-- Estado --}}
            <div>
                <div class="flex items-center">
                    <label for="activo" class="block text-sm font-medium text-gray-700 mr-4">Estado:</label>
                    <label for="activo" class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" id="activo" name="activo" value="1" class="sr-only peer" {{ old('activo', $cliente->activo) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer dark:bg-gray-700 peer-checked:bg-blue-600 transition-colors"></div>
                        <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.clientes.edit', $cliente) }}' }))"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Editar
            </button>
            @if (request()->ajax())
                <button type="button" @click="$dispatch('close-modal')"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded hover:bg-gray-400">
                    Cerrar
                </button>
            @else
                <a href="{{ route('admin.clientes.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded hover:bg-gray-400">
                    Volver
                </a>
            @endif
        </div>
    </div>
</div>