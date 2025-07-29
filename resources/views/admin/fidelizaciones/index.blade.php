{{-- admin/fidelizacion/index.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Programa de Fidelización</h1>

<!-- Filtros y Búsqueda -->
        <div class="bg-white p-3 rounded border border-gray-200 mb-4">
            <form action="{{ route('admin.fidelizaciones.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
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
                    <select name="nivel" id="nivel" onchange="this.form.submit()" class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                        <option value="">-- Todos los niveles --</option>            
                        <option value="oro" {{ request('nivel') == 'oro' ? 'selected' : '' }}>Oro</option>            
                        <option value="plata" {{ request('nivel') == 'plata' ? 'selected' : '' }}>Plata</option>                 
                        <option value="bronce" {{ request('nivel') == 'bronce' ? 'selected' : '' }}>Bronce</option>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nivel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Puntos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Última Actualización</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fidelizaciones as $fidelizacion)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $fidelizacion->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $fidelizacion->cliente->nombre }} {{ $fidelizacion->cliente->apellido }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @switch($fidelizacion->nivel)
                                @case('bronce') bg-amber-500 text-white @break
                                @case('plata') bg-gray-300 text-gray-800 @break
                                @case('oro') bg-yellow-400 text-gray-800 @break
                            @endswitch">
                            {{ ucfirst($fidelizacion->nivel) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $fidelizacion->puntos_acumulados }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $fidelizacion->fecha_ultima_actualizacion ? \Carbon\Carbon::parse($fidelizacion->fecha_ultima_actualizacion)->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.fidelizaciones.show', $fidelizacion) }}' } }))"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                            Ver
                        </button>
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.fidelizaciones.edit', $fidelizacion) }}' } }))"
                            class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                            Editar
                        </button>
                        <form action="{{ route('admin.fidelizaciones.destroy', $fidelizacion) }}" method="POST" class="inline-block" x-data 
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
                        No hay registros de fidelización
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $fidelizaciones->appends(request()->query())->links() }}
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