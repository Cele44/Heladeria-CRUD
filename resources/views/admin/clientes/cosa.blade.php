@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Productos</h1>

    <a href="{{ route('admin.productos.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-4">
        Nuevo Producto
    </a>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                <tr>
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Nombre</th>
                    <th class="p-3 border-b">Categoría</th>
                    <th class="p-3 border-b">Precio</th>
                    <th class="p-3 border-b">Disponible</th>
                    <th class="p-3 border-b">Personalizado</th>
                    <th class="p-3 border-b">Ingredientes</th>
                    <th class="p-3 border-b">Tiempo Prep.</th>
                    <th class="p-3 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                @foreach($productos as $producto)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $producto->id }}</td>
                    <td class="p-3 border-b">
                        <div class="flex items-start gap-3">
                            @if($producto->imagen_url)
                                <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 text-gray-500 flex items-center justify-center rounded">
                                    N/A
                                </div>
                            @endif

                            <div>
                                <div class="font-semibold text-gray-900">{{ $producto->nombre }}</div>
                                <div class="text-xs text-gray-600">{{ $producto->descripcion ?: 'Sin descripción' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 border-b">{{ $producto->categoria?->nombre }}</td>
                    <td class="p-3 border-b">${{ number_format($producto->precio_base, 2) }}</td>
                    <td class="p-3 border-b">
                        <span class="{{ $producto->disponible ? 'text-green-600' : 'text-red-600' }}">
                            {{ $producto->disponible ? 'Disponible' : 'No disponible' }}
                        </span>
                    </td>
                    <td class="p-3 border-b">
                        {{ $producto->es_personalizado ? 'Sí' : 'No' }}
                    </td>
                    <td class="p-3 border-b">
                        @if($producto->ingredientes->isNotEmpty())
                            {{ $producto->ingredientes->pluck('nombre')->implode(', ') }}
                        @else
                            Sin ingredientes
                        @endif
                    </td>
                    <td class="p-3 border-b">
                        {{ $producto->tiempo_preparacion }} min
                    </td>
                    <td class="p-3 border-b space-x-2">
                        <a href="{{ route('admin.productos.show', ['producto' => $producto->id]) }}"
                           class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs hover:bg-blue-200">Ver</a>
                        <a href="{{ route('admin.productos.edit', ['producto' => $producto->id]) }}"
                           class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs hover:bg-yellow-200">Editar</a>
                        <form action="{{ route('admin.productos.destroy', ['producto' => $producto->id]) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs hover:bg-red-200">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $productos->links() }}
    </div>
</div>
@endsection