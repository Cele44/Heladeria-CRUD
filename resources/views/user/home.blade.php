@extends('layout.base')

@section('content')

    <!-- HERO - Intro -->
    <section class="bg-gradient-to-br from-pink-100 to-purple-100 rounded-xl p-8 mb-12 shadow-sm">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-pink-700 mb-4">¡Bienvenido a Heladería Dulce Nieve! 🍨</h1>
            <p class="text-lg text-gray-700 mb-6 max-w-xl mx-auto">
                Disfruta de helados artesanales con ingredientes naturales, promociones irresistibles y sabores únicos.
            </p>
            <a href="{{ route('menu') }}" class="bg-pink-600 text-white px-6 py-2 rounded-full text-sm hover:bg-pink-700 transition">
                Ver el Menú
            </a>
        </div>
    </section>

    <!-- Categorías -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-pink-600 mb-6 text-center">🍧 Categorías Populares</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($categorias as $categoria)
                <div class="bg-white rounded-xl shadow-md border border-pink-100 hover:shadow-lg transition transform hover:-translate-y-1">
                    @if($categoria->imagen_url)
                        <img src="{{ asset($categoria->imagen_url) }}" alt="{{ $categoria->nombre }}" class="w-full h-100 object-cover rounded-t-xl">
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-pink-700 flex items-center justify-center gap-2">
                            🍨 {{ $categoria->nombre }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-2 text-center">{{ $categoria->descripcion }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Ingredientes -->
    <section class="mb-8">
        <h2 class="text-3xl font-bold text-pink-600 mb-6 text-center">🧁 Ingredientes Destacados</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @foreach($ingredientes as $ingrediente)
                <div class="bg-white rounded-xl shadow border border-gray-100 hover:shadow-md transition transform hover:-translate-y-1">
                    @if($ingrediente->imagen_url)
                        <img src="{{ asset($ingrediente->imagen_url) }}" alt="{{ $ingrediente->nombre }}" class="w-full h-100 object-cover rounded-t-xl">
                    @endif
                    <div class="p-3 text-center">
                        <h4 class="text-lg font-semibold text-pink-700 mb-1">{{ $ingrediente->nombre }}</h4>
                        <p class="text-sm text-gray-600">{{ $ingrediente->descripcion }}</p>
                        @if($ingrediente->precio_extra > 0)
                            <p class="text-xs text-gray-500 mt-1">+ ${{ number_format($ingrediente->precio_extra, 2) }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
