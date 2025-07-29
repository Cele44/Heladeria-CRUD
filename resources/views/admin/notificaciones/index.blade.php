{{-- admin/notificaciones/index.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Gestión de Notificaciones</h1>

    <div class="flex justify-between items-center mb-6">
        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.notificaciones.create') }}' } }))">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nueva Notificación
        </button>

        <div class="flex space-x-4">
            <form action="{{ route('admin.notificaciones.index') }}" method="GET" class="flex items-center">
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
            </form>

            <select name="tipo" onchange="window.location.href='{{ route('admin.notificaciones.index') }}?tipo='+this.value"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos los tipos</option>
                <option value="promocion" {{ request('tipo') == 'promocion' ? 'selected' : '' }}>Promoción</option>
                <option value="nuevo_sabor" {{ request('tipo') == 'nuevo_sabor' ? 'selected' : '' }}>Nuevo Sabor</option>
                <option value="pedido" {{ request('tipo') == 'pedido' ? 'selected' : '' }}>Pedido</option>
                <option value="fidelizacion" {{ request('tipo') == 'fidelizacion' ? 'selected' : '' }}>Fidelización</option>
            </select>

            <select name="estado" onchange="window.location.href='{{ route('admin.notificaciones.index') }}?estado='+this.value"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos</option>
                <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Leídas</option>
                <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>No leídas</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($notificaciones as $notificacion)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $notificacion->notificacion_id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $notificacion->cliente->nombre }} {{ $notificacion->cliente->apellido }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $notificacion->titulo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @switch($notificacion->tipo)
                                @case('promocion') bg-purple-100 text-purple-800 @break
                                @case('nuevo_sabor') bg-green-100 text-green-800 @break
                                @case('pedido') bg-blue-100 text-blue-800 @break
                                @case('fidelizacion') bg-yellow-100 text-yellow-800 @break
                            @endswitch">
                            {{ ucfirst(str_replace('_', ' ', $notificacion->tipo)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ \Carbon\Carbon::parse($notificacion->fecha_envio)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $notificacion->leida ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $notificacion->leida ? 'Leída' : 'No leída' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.notificaciones.show', $notificacion) }}' } }))"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                            Ver
                        </button>
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.notificaciones.edit', $notificacion) }}' } }))"
                            class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                            Editar
                        </button>
                        <form action="{{ route('admin.notificaciones.destroy', $notificacion) }}" method="POST" class="inline-block" x-data 
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
                        No hay notificaciones registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $notificaciones->appends(request()->query())->links() }}
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