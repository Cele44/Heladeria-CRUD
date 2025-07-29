{{-- admin/categorias/show.blade.php --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles de la Categoría: {{ $categoria->nombre }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Imagen --}}
            <div>
                @if($categoria->imagen_url)
                    <img src="{{ asset($categoria->imagen_url) }}" alt="{{ $categoria->nombre }}"
                        class="w-full h-64 object-cover rounded-lg">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                        Sin imagen
                    </div>
                @endif
            </div>

            {{-- Información --}}
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">ID</p>
                    <p class="text-gray-900">{{ $categoria->id }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Descripción</p>
                    <p class="text-gray-900">{{ $categoria->descripcion ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Orden de visualización</p>
                    <p class="text-gray-900">{{ $categoria->orden_display }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Estado</p>
                    <span class="px-2 py-1 rounded text-white text-xs {{ $categoria->activa ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $categoria->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.categorias.edit', $categoria) }}' } }))"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Editar
            </button>
            <button type="button" @click="$dispatch('close-modal')"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded hover:bg-gray-400">
                Cerrar
            </button>
        </div>
    </div>
</div>