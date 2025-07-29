{{-- admin/productos/show.blade.php --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles del Producto: {{ $producto->nombre }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Información básica --}}
            <div>
                <div class="mb-6">
                    @if($producto->imagen_url)
                        <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}"
                            class="w-full max-h-64 object-cover rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                            Sin imagen
                        </div>
                    @endif
                </div>

                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-700">ID:</span> {{ $producto->id }}</p>
                    <p><span class="font-semibold text-gray-700">Categoría:</span> {{ $producto->categoria->nombre }}</p>
                    <p><span class="font-semibold text-gray-700">Precio:</span> {{ number_format($producto->precio_base, 2) }} €</p>
                    <p><span class="font-semibold text-gray-700">Tiempo preparación:</span> {{ $producto->tiempo_preparacion ? $producto->tiempo_preparacion.' minutos' : 'N/A' }}</p>
                    <p>
                        <span class="font-semibold text-gray-700">Estado:</span>
                        <span class="px-2 py-1 rounded text-white text-xs {{ $producto->disponible ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $producto->disponible ? 'Disponible' : 'No disponible' }}
                        </span>
                    </p>
                    <p>
                        <span class="font-semibold text-gray-700">Personalizable:</span>
                        <span class="px-2 py-1 rounded text-white text-xs {{ $producto->es_personalizado ? 'bg-blue-500' : 'bg-gray-500' }}">
                            {{ $producto->es_personalizado ? 'Sí' : 'No' }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Descripción e ingredientes --}}
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                    <p class="text-gray-700">{{ $producto->descripcion ?: 'Sin descripción' }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Ingredientes</h3>
                    @php
                        $porDefecto = $producto->ingredientes->filter(fn($i) => $i->pivot->es_default);
                        $personalizables = $producto->ingredientes->filter(fn($i) => !$i->pivot->es_default);
                    @endphp

                    @if($porDefecto->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-green-700 mb-1">Por defecto:</h4>
                            <ul class="list-disc list-inside text-gray-700 ml-4">
                                @foreach($porDefecto as $ingrediente)
                                    <li>{{ $ingrediente->nombre }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($personalizables->isNotEmpty())
                        <div>
                            <h4 class="text-sm font-semibold text-blue-700 mb-1">Personalizables:</h4>
                            <ul class="list-disc list-inside text-gray-700 ml-4">
                                @foreach($personalizables as $ingrediente)
                                    <li>{{ $ingrediente->nombre }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($producto->ingredientes->isEmpty())
                        <p class="text-gray-500">No hay ingredientes asignados.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.productos.edit', $producto) }}' } }))"
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