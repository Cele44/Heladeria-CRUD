{{-- admin/promociones/index.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Listado de Promociones</h1>

    <div class="flex justify-between items-center mb-6">
        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.promociones.create') }}' } }))">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nueva Promoción
        </button>

        <div class="flex space-x-4">
            <form action="{{ route('admin.promociones.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Buscar..." 
                       value="{{ request('search') }}"
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="ml-2 p-2 text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <select name="tipo" onchange="window.location.href='{{ route('admin.promociones.index') }}?tipo='+this.value"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos los tipos</option>
                <option value="2x1" {{ request('tipo') == '2x1' ? 'selected' : '' }}>2x1</option>
                <option value="combo" {{ request('tipo') == 'combo' ? 'selected' : '' }}>Combo</option>
                <option value="happy_hour" {{ request('tipo') == 'happy_hour' ? 'selected' : '' }}>Happy Hour</option>
                <option value="primera_compra" {{ request('tipo') == 'primera_compra' ? 'selected' : '' }}>Primera Compra</option>
                <option value="cumpleaños" {{ request('tipo') == 'cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
            </select>

            <select name="estado" onchange="window.location.href='{{ route('admin.promociones.index') }}?estado='+this.value"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos</option>
                <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activas</option>
                <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivas</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descuento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Días</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vigencia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items Combo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($promociones as $promocion)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $promocion->nombre }}</div>
                                <div class="text-xs text-gray-600">{{ $promocion->descripcion ?: 'Sin descripción' }}</div>
                            </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @switch($promocion->tipo)
                            @case('2x1') 2x1 @break
                            @case('combo') Combo @break
                            @case('happy_hour') Happy Hour @break
                            @case('primera_compra') Primera Compra @break
                            @case('cumpleaños') Cumpleaños @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($promocion->tipo == 'combo')
                            {{ $promocion->descuento_porcentaje }}% (Combo)
                        @else
                            {{ $promocion->descuento_porcentaje }}%
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @php
                            $dias = $promocion->dias_aplicables ? json_decode($promocion->dias_aplicables) : [];
                            $todosLosDias = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
                        @endphp

                        {{ $dias && count(array_diff($todosLosDias, $dias)) === 0 ? 'Todos los días' : implode(', ', $dias) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($promocion->fecha_inicio && $promocion->fecha_fin)
                            {{ \Carbon\Carbon::parse($promocion->fecha_inicio)->format('d/m/Y') }}  - {{ \Carbon\Carbon::parse($promocion->fecha_fin)->format('d/m/Y') }}
                        @else
                            Sin fecha límite
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($promocion->tipo === 'combo' && $promocion->combo_detalle)
                            @php
                                $combo = json_decode($promocion->combo_detalle, true);
                                $items = [];
                            @endphp
                            @foreach($combo['items'] ?? [] as $item)
                                @php
                                    if ($item['tipo'] === 'producto') {
                                        $producto = \App\Models\Producto::find($item['id']);
                                        $items[] = ($producto ? $producto->nombre : 'Producto eliminado') . ' (x' . $item['cantidad'] . ')';
                                    } elseif ($item['tipo'] === 'ingrediente') {
                                        $ingrediente = \App\Models\Ingrediente::find($item['id']);
                                        $items[] = ($ingrediente ? $ingrediente->nombre : 'Ingrediente eliminado') . ' (x' . $item['cantidad'] . ')';
                                    }
                                @endphp
                            @endforeach
                            {{ implode(', ', $items) }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 rounded text-white text-xs {{ $promocion->activa ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $promocion->activa ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.promociones.show', $promocion) }}' } }))"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                            Ver
                        </button>
                        
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.promociones.edit', $promocion) }}' } }))"
                            class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                            Editar
                        </button>
                        <form action="{{ route('admin.promociones.destroy', $promocion) }}" method="POST" class="inline-block" x-data 
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
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                        No hay promociones registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $promociones->appends(request()->query())->links() }}
    </div>
</div>
@include('components.modal-wrapper')
@include('components.delete-confirmation')
@endsection