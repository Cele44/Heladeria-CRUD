{{-- admin/fidelizacion/show.blade.php --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles de Fidelización</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Información del Cliente --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Información del Cliente</h3>
                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-700">Nombre:</span> {{ $fidelizacion->cliente->nombre }} {{ $fidelizacion->cliente->apellido }}</p>
                    <p><span class="font-semibold text-gray-700">Email:</span> {{ $fidelizacion->cliente->email }}</p>
                    <p><span class="font-semibold text-gray-700">Teléfono:</span> {{ $fidelizacion->cliente->telefono ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Información de Fidelización --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">Estado de Fidelización</h3>
                <div class="space-y-2">
                    <p>
                        <span class="font-semibold text-gray-700">Nivel:</span>
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @switch($fidelizacion->nivel)
                                @case('bronce') bg-amber-500 text-white @break
                                @case('plata') bg-gray-300 text-gray-800 @break
                                @case('oro') bg-yellow-400 text-gray-800 @break
                            @endswitch">
                            {{ ucfirst($fidelizacion->nivel) }}
                        </span>
                    </p>
                    <p><span class="font-semibold text-gray-700">Puntos Acumulados:</span> {{ $fidelizacion->puntos_acumulados }}</p>
                    <p><span class="font-semibold text-gray-700">Última Actualización:</span>    
                        {{ $fidelizacion->fecha_ultima_actualizacion ? \Carbon\Carbon::parse($fidelizacion->fecha_ultima_actualizacion)->format('d/m/Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Historial de Transacciones --}}
        <div>
            <h3 class="text-lg font-semibold mb-4">Últimas Transacciones</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Puntos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motivo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pedido</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($fidelizacion->transacciones as $transaccion)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($transaccion->fecha_transaccion)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $transaccion->tipo == 'ganado' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($transaccion->tipo) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $transaccion->puntos }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $transaccion->motivo }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($transaccion->pedido_id)
                                    #{{ $transaccion->pedido_id }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay transacciones registradas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.fidelizaciones.edit', $fidelizacion) }}' } }))"
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