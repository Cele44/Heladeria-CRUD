@extends('layout.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#fdf2f8] to-[#fce7f3] py-10">
  <div class="max-w-6xl mx-auto px-4">

    {{-- Card de perfil --}}
    <div class="mb-10 overflow-hidden rounded-2xl shadow-xl bg-white/80 backdrop-blur-md border border-[#fbcfe8]">
      <div class="bg-gradient-to-r 
        @if(($fidelizacion->puntos_acumulados ?? 0) >= 2000) from-[#c084fc] to-[#e879f9]
        @elseif(($fidelizacion->puntos_acumulados ?? 0) >= 1000) from-[#f9a8d4] to-[#fbcfe8]
        @elseif(($fidelizacion->puntos_acumulados ?? 0) >= 500) from-[#e0aaff] to-[#d8b4fe]
        @else from-[#f9a8d4] to-[#fbcfe8] @endif
        p-6">
        <div class="flex items-center space-x-6 text-white">
          <div class="relative">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/30">
              <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A7.5 7.5 0 0112 15.5a7.5 7.5 0 016.879 2.304M12 12a4 4 0 100-8 4 4 0 000 8z"/>
              </svg>
            </div>
          </div>
          <div class="flex-1">
            <h2 class="text-3xl font-bold mb-1">{{ $cliente->nombre }} {{ $cliente->apellido }}</h2>
            <p class="text-white/80 text-lg">Cliente desde {{ \Carbon\Carbon::parse($fechaRegistro)->translatedFormat('F Y') }}</p>
            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-white/30 text-white text-sm font-semibold">
              {{ $fidelizacion->nivel ?? 'Cliente' }}
            </span>
          </div>
          <div class="text-right">
            <div class="bg-white/20 px-6 py-4 rounded-2xl border border-white/30">
              <div class="flex items-center space-x-2 mb-1">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.287 7.04h7.418c.969 0 1.371 1.24.588 1.81l-6 4.352 2.287 7.04c.3.921-.755 1.688-1.54 1.118L12 19.347l-6.989 5.94c-.784.57-1.838-.197-1.54-1.118l2.287-7.04-6-4.352c-.783-.57-.38-1.81.588-1.81h7.418l2.287-7.04z"/>
                </svg>
                <span class="text-3xl font-bold">{{ $fidelizacion->puntos_acumulados ?? 0 }}</span>
              </div>
              <p class="text-white/80 text-sm">puntos acumulados</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabs --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
      <a href="#puntos" class="block p-4 text-center rounded-xl bg-white hover:bg-[#fce7f3] shadow text-pink-600 font-semibold transition">
        ⭐<div>Puntos</div>
      </a>
      <a href="#historial" class="block p-4 text-center rounded-xl bg-white hover:bg-[#fce7f3] shadow text-pink-600 font-semibold transition">
        📋<div>Historial</div>
      </a>
      <a href="#datos" class="block p-4 text-center rounded-xl bg-white hover:bg-[#fce7f3] shadow text-pink-600 font-semibold transition">
        👤<div>Datos</div>
      </a>
    </div>

    {{-- Puntos --}}
    <div id="puntos" class="mb-12">
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow p-6 mb-6">
        <h3 class="text-xl font-semibold text-pink-600 mb-2">Tu Progreso</h3>
        <p class="text-gray-600">1 peso = 1 punto</p>
        <div class="mt-4 bg-[#fbcfe8] rounded-full h-3">
          <div class="bg-gradient-to-r from-[#e879f9] to-[#c084fc] h-3 rounded-full"
               style="width: {{ min((($fidelizacion->puntos_acumulados ?? 0) % 500) / 500 * 100, 100) }}%">
          </div>
        </div>
        <p class="mt-2 text-sm text-gray-600">{{ 500 - (($fidelizacion->puntos_acumulados ?? 0) % 500) }} puntos para la próxima recompensa</p>
      </div>
    </div>

    {{-- Historial --}}
    <div id="historial" class="mb-12">
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow p-6">
        <h3 class="text-2xl font-bold text-pink-600 mb-4">Historial de Pedidos</h3>

        @if($pedidos->isEmpty())
          <p class="text-gray-500">Aún no has realizado ningún pedido.</p>
        @else
          <div class="space-y-6">
            @foreach($pedidos as $pedido)
              <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-3">
                  <div>
                    <h4 class="text-lg font-semibold text-gray-800">Pedido #{{ $pedido->id }}</h4>
                    <p class="text-gray-600 text-sm">Fecha: {{ $pedido->fecha_pedido->format('d M Y') }}</p>
                    <p class="text-gray-600 text-sm">Estado: {{ ucfirst($pedido->estado) }}</p>
                    <p class="text-gray-600 text-sm">Pago: {{ $pedido->metodo_pago }}</p>
                  </div>
                  <div class="text-right">
                    <p class="text-xl font-bold text-pink-600">${{ number_format($pedido->total, 2) }}</p>
                  </div>
                </div>

                @if($pedido->detalles->isNotEmpty())
                  <div class="text-gray-700 text-sm mt-3">
                    <p class="font-semibold">Productos:</p>
                    <ul class="list-disc ml-6">
                      @foreach($pedido->detalles as $detalle)
                        <li>{{ $detalle->producto_nombre ?? 'Producto' }} x {{ $detalle->cantidad }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    {{-- Datos del cliente --}}
    <div id="datos" class="mb-12">
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow p-6">
        <h3 class="text-2xl font-bold text-pink-600 mb-4">Información del Cliente</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <p class="text-gray-600">Nombre:</p>
            <p class="font-semibold text-gray-800">{{ $cliente->nombre }} {{ $cliente->apellido }}</p>
          </div>
          <div>
            <p class="text-gray-600">Email:</p>
            <p class="font-semibold text-gray-800">{{ $cliente->email }}</p>
          </div>
          <div>
            <p class="text-gray-600">Teléfono:</p>
            <p class="font-semibold text-gray-800">{{ $cliente->telefono ?? 'No disponible' }}</p>
          </div>
          <div>
            <p class="text-gray-600">Dirección:</p>
            <p class="font-semibold text-gray-800">{{ $cliente->direccion ?? 'No disponible' }}</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
