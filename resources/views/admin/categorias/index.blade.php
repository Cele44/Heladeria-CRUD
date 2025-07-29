{{-- admin/categorias/index.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Listado de Categorías</h1>

    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mb-4"
    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.categorias.create') }}' } }))">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Nueva Categoría
    </button>

    <!-- Filtros y Búsqueda -->    
    <div class="bg-white p-3 rounded border border-gray-200 mb-4">
        <form action="{{ route('admin.categorias.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
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
                    <option value="1" {{ request('estado', '1') == '1' ? 'selected' : '' }}>Activas</option>                
                    <option value="2" {{ request('estado') == '2' ? 'selected' : '' }}>Todas</option>                     
                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivas</option>
                </select>
            </div>
         </form>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categorias as $categoria)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $categoria->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="flex items-center">
                            @if($categoria->imagen_url)
                                <img class="h-8 w-8 rounded-lg object-cover mr-3" src="{{ asset($categoria->imagen_url) }}" alt="{{ $categoria->nombre }}">
                            @else
                                <div class="h-8 w-8 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                    <span class="text-gray-500 text-xs">🏷️</span>
                                </div>
                            @endif
                            {{ $categoria->nombre }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ Str::limit($categoria->descripcion, 50) ?? 'Sin descripción' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $categoria->orden ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $categoria->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $categoria->activa ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.categorias.show', $categoria) }}' } }))"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                            Ver
                        </button>
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { url: '{{ route('admin.categorias.edit', $categoria) }}' } }))"
                            class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                            Editar
                        </button>
                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="inline-block" x-data
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
                        No hay categorías registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categorias->links() }}
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
