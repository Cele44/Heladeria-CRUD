@extends('layout.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#fdf2f8] to-[#fce7f3] py-10">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-3xl font-bold text-pink-700 mb-8 text-center">🛒 Tu carrito</h1>

    @if (count($carrito) === 0)
      <div class="text-center text-gray-600 bg-white/80 p-6 rounded-xl shadow">
        Tu carrito está vacío.
      </div>
    @else
      <div class="space-y-6">
        @foreach ($carrito as $index => $item)
          <div class="bg-white/90 backdrop-blur-md border border-pink-200 rounded-xl shadow-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 transition hover:shadow-xl">
            <div>
              <h2 class="text-xl font-semibold text-pink-800 mb-1">{{ $item['nombre'] }}</h2>
              <p class="text-sm text-gray-500 mb-2">Precio base: ${{ number_format($item['precio_base'], 2) }}</p>

              @if (!empty($item['ingredientes_extra']))
                <p class="text-sm text-gray-700">Ingredientes extra:</p>
                <ul class="list-disc list-inside text-sm text-gray-600">
                  @foreach ($item['ingredientes_extra'] as $ing)
                    <li>{{ $ing['nombre'] }} (+${{ number_format($ing['precio_extra'], 2) }})</li>
                  @endforeach
                </ul>
              @endif

              @if (!empty($item['nota']))
                <p class="text-sm text-gray-600 mt-1">📝 Nota: {{ $item['nota'] }}</p>
              @endif

              <div class="mt-3 space-y-1">
                <p class="font-bold text-pink-600">
                  Total: ${{ number_format($item['precio_total'] * ($item['cantidad'] ?? 1), 2) }}
                </p>
                <p class="text-sm text-rose-500">
                  ⭐ Puntos ganados: {{ number_format(($item['precio_total'] * ($item['cantidad'] ?? 1)) / 100, 1) }}
                </p>
              </div>
            </div>

            {{-- Actualizar cantidad --}}
            <form action="{{ route('carrito.actualizarCantidad', $index) }}" method="POST" class="flex items-center gap-2">
              @csrf
              @method('PUT')
              <button name="accion" value="restar"
                      class="px-3 py-1 bg-[#fce7f3] hover:bg-pink-200 text-pink-800 font-bold rounded text-lg">
                ➖
              </button>
              <span class="font-bold text-lg text-gray-700">{{ $item['cantidad'] ?? 1 }}</span>
              <button name="accion" value="sumar"
                      class="px-3 py-1 bg-[#fce7f3] hover:bg-pink-200 text-pink-800 font-bold rounded text-lg">
                ➕
              </button>
            </form>
          </div>
        @endforeach
      </div>

      {{-- Botón finalizar --}}
      <form action="{{ route('carrito.finalizar') }}" method="POST" class="mt-8 text-center">
        @csrf
        <button type="submit"
                class="bg-[#86efac] hover:bg-[#4ade80] text-green-900 font-bold px-8 py-3 rounded-full shadow transition">
          ✅ Finalizar pedido
        </button>
      </form>
    @endif
  </div>
</div>
@endsection
