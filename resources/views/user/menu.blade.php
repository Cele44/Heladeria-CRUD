@extends('layout.base')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-0">
        <h1 class="text-3xl font-extrabold text-pink-700 mb-8 text-center">🍨 Nuestro Menú</h1>

        <!-- Barra de búsqueda -->
        <form action="{{ route('menu') }}" method="GET" class="flex flex-wrap gap-2 items-center justify-center mb-6">
            @if ($categoriaId)
                <input type="hidden" name="categoria" value="{{ $categoriaId }}">
            @endif

            <div class="relative w-full sm:w-72">
                <input
                    type="text"
                    name="buscar"
                    id="buscarInput"
                    placeholder="Buscar producto..."
                    value="{{ $buscar }}"
                    class="pl-4 pr-10 py-2 w-full border border-gray-300 rounded-full text-sm focus:ring-pink-300 focus:border-pink-400 shadow-sm"
                    oninput="toggleClearButton()"
                >
                <!-- Botón de limpiar -->
                <button
                    type="button"
                    id="clearButton"
                    onclick="clearSearch()"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm hidden"
                >
                    ✖
                </button>
            </div>

            <button type="submit"
                class="bg-pink-600 text-white px-5 py-2 rounded-full text-sm hover:bg-pink-700 shadow">
                Buscar
            </button>
        </form>

        <!-- Categorías -->
        <div class="flex flex-wrap gap-2 justify-center mb-10">
            <a href="{{ route('menu') }}"
               class="px-4 py-2 rounded-full text-sm font-medium transition
                      {{ is_null($categoriaId) ? 'bg-pink-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-pink-100' }}">
                Todos
            </a>

            @foreach($categorias as $categoria)
                <a href="{{ route('menu', ['categoria' => $categoria->id]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition
                          {{ $categoriaId == $categoria->id ? 'bg-pink-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-pink-100' }}">
                    {{ $categoria->nombre }}
                </a>
            @endforeach
        </div>

        <!-- Productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($productos as $producto)
                <div class="bg-white rounded-2xl shadow-lg border border-pink-100 hover:shadow-xl transition overflow-hidden flex flex-col">
                    @if ($producto->imagen_url)
                        <img src="{{ asset($producto->imagen_url) }}"
                             alt="{{ $producto->nombre }}"
                             class="h-100 w-full object-cover">
                    @endif

                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div class="mb-4">
                            <h2 class="text-lg font-bold text-pink-800">{{ $producto->nombre }}</h2>
                            <p class="text-xs text-gray-500 mb-1">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $producto->descripcion }}</p>
                        </div>

                        <div class="text-left mb-3">
                            <p class="text-pink-600 font-bold text-lg">$ {{ number_format($producto->precio_base, 2) }}</p>
                            <p class="text-xs text-gray-500">⏱ {{ $producto->tiempo_preparacion }} min</p>
                        </div>

                        <div>
                            @if (Auth::check())
                                @if ($producto->es_personalizado)
                                    <a href="{{ route('personalizar', $producto->id) }}"
                                       class="w-full block text-center bg-yellow-400 hover:bg-yellow-500 text-white font-medium py-2 rounded-full text-sm transition">
                                        Personalizar
                                    </a>
                                @else
                                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-medium py-2 rounded-full text-sm transition">
                                            Agregar
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if ($producto->es_personalizado)
                                    <a href="{{ route('login') }}"
                                       class="w-full block text-center bg-yellow-400 hover:bg-yellow-500 text-white font-medium py-2 rounded-full text-sm transition">
                                        Personalizar
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="w-full block text-center bg-pink-500 hover:bg-pink-600 text-white font-medium py-2 rounded-full text-sm transition">
                                        Agregar
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<!-- JS para botón de limpiar -->
<script>
    const input = document.getElementById('buscarInput');
    const clearButton = document.getElementById('clearButton');

    function toggleClearButton() {
        clearButton.classList.toggle('hidden', input.value === '');
    }

    function clearSearch() {
        input.value = '';
        clearButton.classList.add('hidden');
        input.form.submit();
    }

    document.addEventListener('DOMContentLoaded', toggleClearButton);
</script>
