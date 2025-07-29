{{-- admin/promociones/show.blade.php --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles de la Promoción: {{ $promocion->nombre }}</h2>

        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium text-gray-500">ID</p>
                <p class="text-gray-900">{{ $promocion->id }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Descripción</p>
                <p class="text-gray-900">{{ $promocion->descripcion }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Tipo</p>
                    <p class="text-gray-900">
                        @switch($promocion->tipo)
                            @case('2x1') 2x1 @break
                            @case('combo') Combo @break
                            @case('happy_hour') Happy Hour @break
                            @case('primera_compra') Primera Compra @break
                            @case('cumpleaños') Cumpleaños @break
                        @endswitch
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Descuento</p>
                    <p class="text-gray-900">
                        @if($promocion->tipo == 'combo')
                            {{ $promocion->descuento_porcentaje }}% (Combo)
                        @else
                            {{ $promocion->descuento_porcentaje }}%
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Estado</p>
                    <span class="px-2 py-1 rounded text-white text-xs {{ $promocion->activa ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $promocion->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Fecha Inicio</p>
                    <p class="text-gray-900">{{ $promocion->fecha_inicio ? \Carbon\Carbon::parse($promocion->fecha_inicio)->format('d/m/Y') : 'No especificada' }}
</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Fecha Fin</p>
                    <p class="text-gray-900"> {{ $promocion->fecha_fin ? \Carbon\Carbon::parse($promocion->fecha_fin)->format('d/m/Y') : 'No especificada' }}</p>
                </div>
            </div>

            @if($promocion->dias_aplicables)
                <div>
                    <p class="text-sm font-medium text-gray-500">Días Aplicables</p>
                    <p class="text-gray-900">
                        @foreach(json_decode($promocion->dias_aplicables) as $dia)
                            <span class="capitalize">{{ $dia }}</span>
                            @if(!$loop->last), @endif
                        @endforeach
                    </p>
                </div>
            @endif

            @if($promocion->tipo == 'combo' && $promocion->combo_detalle)
                <div>
                    <p class="text-sm font-medium text-gray-500">Detalles del Combo</p>
                    <div class="mt-2 space-y-2">
                        @foreach(json_decode($promocion->combo_detalle)->items as $item)
                            <div class="flex items-center justify-between">
                                <span>
                                    @if($item->tipo == 'producto')
                                        @php
                                            $producto = $productos->firstWhere('id', $item->id);
                                            $nombre = $producto ? $producto->nombre : 'Producto eliminado';
                                        @endphp
                                        Producto: {{ $nombre }}
                                    @else
                                        @php
                                            $ingrediente = $ingredientes->firstWhere('id', $item->id);
                                            $nombre = $ingrediente ? $ingrediente->nombre : 'Ingrediente eliminado';
                                        @endphp
                                        Ingrediente: {{ $nombre }}
                                    @endif
                                </span>
                                <span class="text-gray-600">x{{ $item->cantidad }}</span>
                            </div>
                        @endforeach
                        <div class="pt-2 border-t border-gray-200 font-semibold">
                            Precio del Combo: ${{ number_format(json_decode($promocion->combo_detalle)->precio_combo, 2) }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.promociones.edit', $promocion) }}' } }))"
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