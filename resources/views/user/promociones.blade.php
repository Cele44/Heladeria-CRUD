@extends('layout.base')

@section('content')
    <!-- Hero -->
    <div class="py-10 px-4 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl shadow-md mb-10 text-center">
        <h1 class="text-4xl font-bold mb-2">🎉 Promociones Especiales</h1>
        <p class="text-lg opacity-90">Aprovecha nuestras increíbles ofertas y ahorra en tus helados favoritos</p>
    </div>

    <!-- Tabs resumen -->
    <div class="flex gap-4 mb-6 text-sm">
        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">Activas ({{ $activas->count() }})</span>
        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">Próximas ({{ $proximas->count() }})</span>
        <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-600">Anteriores ({{ $anteriores->count() }})</span>
    </div>

    <!-- Promociones activas -->
    <div class="mb-12">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">Promociones Activas</h2>
        @if($activas->isEmpty())
            <div class="text-center py-12">
                <div class="text-5xl mb-4">🎁</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay promociones activas</h3>
                <p class="text-gray-500">¡Pero no te preocupes! Pronto tendremos nuevas ofertas.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($activas as $promo)
                    @include('components.promocion-card', ['promo' => $promo, 'estado' => 'Activa'])
                @endforeach
            </div>
        @endif
    </div>

    <!-- Promociones próximas -->
    <div class="mb-12">
        <h2 class="text-xl font-semibold text-yellow-600 mb-4">Promociones Próximas</h2>
        @if($proximas->isEmpty())
            <div class="text-center py-12">
                <div class="text-5xl mb-4">⏰</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay promociones próximas</h3>
                <p class="text-gray-500">Mantente atento a nuestras redes sociales para nuevas ofertas.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 opacity-75">
                @foreach ($proximas as $promo)
                    @include('components.promocion-card', ['promo' => $promo, 'estado' => 'Próximamente'])
                @endforeach
            </div>
        @endif
    </div>

    <!-- Promociones anteriores -->
    <div class="mb-12">
        <h2 class="text-xl font-semibold text-gray-600 mb-4">Promociones Finalizadas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 opacity-50">
            @foreach ($anteriores as $promo)
                @include('components.promocion-card', ['promo' => $promo, 'estado' => 'Finalizada'])
            @endforeach
        </div>
    </div>

    <!-- ¿Cómo funcionan nuestras promociones? -->
    <div class="mt-16">
        <div class="bg-gradient-to-r from-pink-50 to-purple-50 border border-pink-200 rounded-lg p-8">
            <h2 class="text-2xl font-bold text-pink-700 mb-6 flex items-center gap-2">
                🍦 ¿Cómo funcionan nuestras promociones?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-sm text-gray-700">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center text-2xl">🎁</div>
                    <h3 class="font-semibold mb-1">2x1</h3>
                    <p>Compra uno y llévate otro gratis en productos seleccionados</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center text-2xl">👨‍👩‍👧‍👦</div>
                    <h3 class="font-semibold mb-1">Combos</h3>
                    <p>Paquetes especiales con descuentos para compartir</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 bg-orange-100 rounded-full flex items-center justify-center text-2xl">⏰</div>
                    <h3 class="font-semibold mb-1">Happy Hour</h3>
                    <p>Descuentos especiales en horarios específicos</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 bg-purple-100 rounded-full flex items-center justify-center text-2xl">⭐</div>
                    <h3 class="font-semibold mb-1">Especiales</h3>
                    <p>Promociones para nuevos clientes y cumpleañeros</p>
                </div>
            </div>
        </div>
    </div>
@endsection
