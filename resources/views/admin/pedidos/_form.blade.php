{{-- admin/pedidos/_form.blade.php --}}
<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Estado --}}
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
            <select name="estado" id="estado" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('estado') border-red-500 @enderror">
                <option value="pendiente" {{ old('estado', $pedido->estado ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="preparando" {{ old('estado', $pedido->estado ?? '') == 'preparando' ? 'selected' : '' }}>Preparando</option>
                <option value="entregado" {{ old('estado', $pedido->estado ?? '') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ old('estado', $pedido->estado ?? '') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @error('estado')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Método de Pago --}}
        <div>
            <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de Pago *</label>
            <select name="metodo_pago" id="metodo_pago" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('metodo_pago') border-red-500 @enderror">
                <option value="efectivo" {{ old('metodo_pago', $pedido->metodo_pago ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="tarjeta" {{ old('metodo_pago', $pedido->metodo_pago ?? '') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                <option value="qr" {{ old('metodo_pago', $pedido->metodo_pago ?? '') == 'qr' ? 'selected' : '' }}>QR</option>
                <option value="transferencia" {{ old('metodo_pago', $pedido->metodo_pago ?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
            </select>
            @error('metodo_pago')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Dirección --}}
        <div class="md:col-span-2">
            <label for="direccion_entrega" class="block text-sm font-medium text-gray-700">Dirección de Entrega</label>
            <input type="text" name="direccion_entrega" id="direccion_entrega" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('direccion_entrega') border-red-500 @enderror"
                value="{{ old('direccion_entrega', $pedido->direccion_entrega ?? '') }}">
            @error('direccion_entrega')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Notas --}}
    <div>
        <label for="notas" class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" id="notas" rows="3"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas', $pedido->notas ?? '') }}</textarea>
        @error('notas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botones --}}
    <div class="flex space-x-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $isEdit ? 'Actualizar Pedido' : 'Crear Pedido' }}
        </button>

        <a href="{{ $isEdit ? route('admin.pedidos.show', $pedido) : route('admin.pedidos.index') }}"
           class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
            Cancelar
        </a>
    </div>
</form>