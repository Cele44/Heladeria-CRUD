{{-- admin/pedidos/show.blade.php --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles del Pedido #{{ $pedido->id }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Información del Pedido --}}
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Información del Pedido</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Cliente:</span> {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</p>
                        <p><span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}</p>
                        <p>
                            <span class="font-semibold">Estado:</span>
                            <span class="px-2 py-1 rounded text-white text-xs 
                                @if($pedido->estado == 'pendiente') bg-yellow-500
                                @elseif($pedido->estado == 'preparando') bg-blue-500
                                @elseif($pedido->estado == 'entregado') bg-green-500
                                @else bg-red-500
                                @endif">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </p>
                        <p><span class="font-semibold">Método de Pago:</span> {{ ucfirst($pedido->metodo_pago) }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Dirección y Notas</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Dirección:</span> {{ $pedido->direccion_entrega ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Notas:</span> {{ $pedido->notas ?? 'Ninguna' }}</p>
                    </div>
                </div>
            </div>

            {{-- Resumen del Pedido --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">Resumen del Pedido</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="divide-y divide-gray-200">
                        @foreach($pedido->detalles as $detalle)
                        <div class="py-2">
                            <div class="flex justify-between">
                                <span>
                                    {{ $detalle->cantidad }}x 
                                    @if($detalle->producto)
                                        {{ $detalle->producto->nombre }}
                                    @else
                                        <span class="italic text-gray-400">Producto eliminado</span>
                                    @endif
                                </span>
                                <span>{{ number_format($detalle->subtotal, 2) }} €</span>
                            </div>
                            @if($detalle->ingredientes->count())
                                <p class="text-xs text-gray-500 mt-1">
                                    <strong>Ingredientes:</strong> 
                                    {{ $detalle->ingredientes->pluck('nombre')->implode(', ') }}
                                </p>
                            @endif
                            @if($detalle->instrucciones_especiales)
                                <p class="text-xs text-gray-500 mt-1">
                                    <strong>Notas:</strong> {{ $detalle->instrucciones_especiales }}
                                </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <div class="flex justify-between font-bold">
                            <span>Total:</span>
                            <span>{{ number_format($pedido->total, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.pedidos.edit', $pedido) }}' } }))"
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