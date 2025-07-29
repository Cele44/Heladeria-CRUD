{{-- admin/pedidos/index.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Listado de Pedidos</h1>

<!-- Filtros y Búsqueda -->
        <div class="bg-white p-3 rounded border border-gray-200 mb-4">
            <form action="{{ route('admin.pedidos.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <!-- Campo de búsqueda -->
                <div class="flex-1 relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                        class="w-full pr-8 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm" 
                        placeholder="Buscar por Nombre o descripción"
                        oninput="toggleClearBtn()"
                    >

                    {{-- Botón "x" para limpiar --}}
                    <button type="button" 
                        id="clearSearchBtn"
                        onclick="clearSearch()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 text-sm hidden">
                        &times;
                    </button>
                </div> 
                <!-- Filtro por estado -->
                <div>
                    <select name="estado" id="estado" onchange="this.form.submit()" class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                        <option value="">-- Todos los tipos --</option>            
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>            
                        <option value="preparando" {{ request('estado') == 'preparando' ? 'selected' : '' }}>Preparando</option>                 
                        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>                 
                    </select>                
                </div> 
            </form>
        </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ítems</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descuento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pedidos as $pedido)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">#{{ $pedido->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                            @elseif($pedido->estado == 'preparando') bg-blue-100 text-blue-800
                            @elseif($pedido->estado == 'entregado') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        {{ $pedido->detalles->sum('cantidad') }}
                    </td>
                    <td class="px-4 py-2">
                        @php
                            $promocion = $pedido->detalles->firstWhere('promocion_id', '!=', null)?->promocion;
                        @endphp

                        @if($promocion)
                            {{ $promocion->descuento_porcentaje }}% - {{ $promocion->nombre }}
                        @else
                            Sin descuento
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ number_format($pedido->total, 2) }} Bs
                    </td>
                    <td class="px-4 py-2">{{ ucfirst($pedido->metodo_pago) }}</td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.pedidos.show', $pedido) }}' } }))"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                            Ver
                        </button>
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.pedidos.edit', $pedido) }}' } }))"
                            class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                            Editar
                        </button>
                        <form action="{{ route('admin.pedidos.destroy', $pedido) }}" method="POST" class="inline-block" x-data 
                                @submit.prevent="$dispatch('open-delete-modal', { form: $el })">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        No hay pedidos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pedidos->links() }}
    </div>
</div>
@include('components.modal-wrapper')
@include('components.delete-confirmation')
@endsection

        @section('scripts')
<script>
    // Funciones para el buscador
        function toggleClearBtn() {
            const input = document.getElementById('search');
            const btn = document.getElementById('clearSearchBtn');
            if (input.value.trim() !== '') {
                btn.classList.remove('hidden');
            } else {
                btn.classList.add('hidden');
            }
        }

        function clearSearch() {
            const input = document.getElementById('search');
            input.value = '';
            toggleClearBtn();
            input.form.submit();
        }

        document.addEventListener('DOMContentLoaded', toggleClearBtn);
</script>
@endsection