@extends('layout.base')

@section('content')
    <h1 class="text-2xl font-bold text-pink-600 mb-4">
        Personalizar: {{ $producto->nombre }}
    </h1>

    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
        @csrf

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Ingredientes disponibles 🧂</h2>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($producto->ingredientes as $ingrediente)
                    <label class="flex items-center space-x-2 bg-gray-100 px-3 py-2 rounded">
                        <input type="checkbox"
                               name="ingredientes[]"
                               value="{{ $ingrediente->id }}"
                               class="accent-pink-500"
                               {{ $ingrediente->pivot->es_default ? 'checked disabled' : '' }}>
                        <span>{{ $ingrediente->nombre }}</span>
                        @if (!$ingrediente->pivot->es_default)
                            <span class="text-sm text-gray-500">+ ${{ number_format($ingrediente->precio_extra, 2) }}</span>
                        @else
                            <span class="text-sm text-green-500">(incluido)</span>
                        @endif
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <label for="nota" class="block font-medium text-gray-700 mb-1">📝 Nota para el pedido (opcional)</label>
            <textarea name="nota" id="nota" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2"
                      placeholder="Sin azúcar, sin crema, etc.">{{ old('nota') }}</textarea>
        </div>

        <div class="flex justify-between items-center mt-6">
            <p class="text-lg font-bold text-pink-700">
                Total: <span id="total">${{ number_format($producto->precio_base, 2) }}</span>
            </p>

            <button type="submit"
                    class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2 rounded shadow">
                Agregar al carrito 🛒
            </button>
        </div>
    </form>

    <a href="{{ route('menu') }}" class="text-sm text-pink-500 hover:underline mt-4 inline-block">
        ← Volver al menú
    </a>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:not([disabled])');
        const totalEl = document.getElementById('total');
        const basePrice = {{ $producto->precio_base }};

        function updateTotal() {
            let total = basePrice;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const label = cb.closest('label');
                    const priceSpan = label.querySelector('span.text-sm.text-gray-500');
                    if (priceSpan) {
                        const priceText = priceSpan.textContent.trim().replace('+ $', '');
                        total += parseFloat(priceText);
                    }
                }
            });

            totalEl.textContent = `$${total.toFixed(2)}`;
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
        updateTotal(); // inicial
    });
</script>
@endpush
