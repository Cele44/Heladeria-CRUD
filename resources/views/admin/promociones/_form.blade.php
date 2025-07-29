{{-- admin/promociones/_form.blade.php --}}
<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nombre --}}
        <div class="md:col-span-2">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
            <input type="text" name="nombre" id="nombre" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                   value="{{ old('nombre', $promocion->nombre ?? '') }}">
            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="md:col-span-2">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción *</label>
            <textarea name="descripcion" id="descripcion" rows="3" required
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $promocion->descripcion ?? '') }}</textarea>
            @error('descripcion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tipo --}}
        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo *</label>
            <select name="tipo" id="tipo" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-500 @enderror">
                <option value="">Seleccione un tipo</option>
                <option value="2x1" {{ old('tipo', $promocion->tipo ?? '') == '2x1' ? 'selected' : '' }}>2x1</option>
                <option value="combo" {{ old('tipo', $promocion->tipo ?? '') == 'combo' ? 'selected' : '' }}>Combo</option>
                <option value="happy_hour" {{ old('tipo', $promocion->tipo ?? '') == 'happy_hour' ? 'selected' : '' }}>Happy Hour</option>
                <option value="primera_compra" {{ old('tipo', $promocion->tipo ?? '') == 'primera_compra' ? 'selected' : '' }}>Primera Compra</option>
                <option value="cumpleaños" {{ old('tipo', $promocion->tipo ?? '') == 'cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
            </select>
            @error('tipo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descuento Porcentaje --}}
        <div id="descuento_porcentaje_field" class="{{ old('tipo', $promocion->tipo ?? '') == 'combo' ? 'hidden' : '' }}">
            <label for="descuento_porcentaje" class="block text-sm font-medium text-gray-700">Descuento (%)</label>
            <input type="number" step="0.01" min="0" max="100" name="descuento_porcentaje" id="descuento_porcentaje"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descuento_porcentaje') border-red-500 @enderror"
                   value="{{ old('descuento_porcentaje', $promocion->descuento_porcentaje ?? '') }}">
            @error('descuento_porcentaje')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fechas --}}
        <div>
            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('fecha_inicio') border-red-500 @enderror"
                    value="{{ old('fecha_inicio', optional($promocion?->fecha_inicio)->format('Y-m-d\TH:i')) }}"
            @error('fecha_inicio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('fecha_fin') border-red-500 @enderror"
                    value="{{ old('fecha_fin', optional($promocion?->fecha_fin)->format('Y-m-d\TH:i')) }}"
            @error('fecha_fin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Días Aplicables --}}
        <div class="md:col-span-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Días Aplicables</label>
            <div class="grid grid-cols-5 md:grid-cols-10 gap-2">
                @foreach($diasSemana as $dia)
                    <div class="flex items-center">
                        <input type="checkbox" name="dias_aplicables[]" id="dia_{{ $dia }}" 
                               value="{{ $dia }}" 
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               @if(in_array($dia, old('dias_aplicables', $diasSeleccionados ?? []))) checked @endif>
                        <label for="dia_{{ $dia }}" class="ml-2 text-sm text-gray-700">
                            {{ ucfirst($dia) }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('dias_aplicables')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Combo Detalle --}}
        <div id="combo_detalle_container" class="md:col-span-2 {{ old('tipo', $promocion->tipo ?? '') != 'combo' ? 'hidden' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-2">Detalles del Combo</label>
            
            <div class="space-y-4">
                {{-- Items del Combo --}}
                <div id="combo_items_container" class="space-y-2">
                    @if($isEdit && $promocion->tipo == 'combo' && $promocion->combo_detalle)
                        @foreach(json_decode($promocion->combo_detalle)->items as $item)
                            <div class="flex items-end space-x-2 combo-item">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700">Item</label>
                                    <select name="combo_items[{{ $loop->index }}][id]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        @foreach($productos as $producto)
                                            <option value="producto_{{ $producto->id }}" {{ $item->tipo == 'producto' && $item->id == $producto->id ? 'selected' : '' }}>
                                                Producto: {{ $producto->nombre }}
                                            </option>
                                        @endforeach
                                        @foreach($ingredientes as $ingrediente)
                                            <option value="ingrediente_{{ $ingrediente->id }}" {{ $item->tipo == 'ingrediente' && $item->id == $ingrediente->id ? 'selected' : '' }}>
                                                Ingrediente: {{ $ingrediente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24">
                                    <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                                    <input type="number" name="combo_items[{{ $loop->index }}][cantidad]" min="1" value="{{ $item->cantidad }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button type="button" class="remove-combo-item px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Eliminar
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <button type="button" id="add_combo_item" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Añadir Item
                </button>

                {{-- Precio Combo --}}
                <div class="mt-4">
                    <label for="precio_combo" class="block text-sm font-medium text-gray-700">Precio del Combo</label>
                    <input type="number" step="0.01" min="0" name="precio_combo" id="precio_combo"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('precio_combo', $isEdit && $promocion->tipo == 'combo' && $promocion->combo_detalle ? json_decode($promocion->combo_detalle)->precio_combo : '') }}">
                </div>
            </div>
        </div>

        {{-- Activa --}}
        <div class="flex items-center">
            <label for="activa" class="block text-sm font-medium text-gray-700 mr-4">Activa:</label>
            <label for="activa" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="activa" name="activa" value="1" class="sr-only peer"
                    {{ old('activa', $promocion->activa ?? true) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
            </label>
        </div>

    </div>

    {{-- Botones --}}
    <div class="flex space-x-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $isEdit ? 'Actualizar Promoción' : 'Crear Promoción' }}
        </button>

        <a href="{{ route('admin.promociones.index') }}"
           class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
            Cancelar
        </a>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campos según tipo
        const tipoSelect = document.getElementById('tipo');
        const descuentoField = document.getElementById('descuento_porcentaje_field');
        const comboField = document.getElementById('combo_detalle_container');

        function toggleFields() {
            if (tipoSelect.value === 'combo') {
                descuentoField.classList.add('hidden');
                comboField.classList.remove('hidden');
            } else {
                descuentoField.classList.remove('hidden');
                comboField.classList.add('hidden');
            }
        }

        tipoSelect.addEventListener('change', toggleFields);
        toggleFields(); // Ejecutar al cargar

        // Manejar items de combo
        const comboItemsContainer = document.getElementById('combo_items_container');
        const addComboItemBtn = document.getElementById('add_combo_item');
        let itemCount = comboItemsContainer.querySelectorAll('.combo-item').length;

        addComboItemBtn.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'flex items-end space-x-2 combo-item';
            newItem.innerHTML = `
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Item</label>
                    <select name="combo_items[${itemCount}][id]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach($productos as $producto)
                            <option value="producto_{{ $producto->id }}">Producto: {{ $producto->nombre }}</option>
                        @endforeach
                        @foreach($ingredientes as $ingrediente)
                            <option value="ingrediente_{{ $ingrediente->id }}">Ingrediente: {{ $ingrediente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-24">
                    <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                    <input type="number" name="combo_items[${itemCount}][cantidad]" min="1" value="1"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="button" class="remove-combo-item px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Eliminar
                </button>
            `;
            comboItemsContainer.appendChild(newItem);
            itemCount++;
        });

        // Delegación de eventos para eliminar items
        comboItemsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-combo-item')) {
                e.target.closest('.combo-item').remove();
                // Reindexar los items
                const items = comboItemsContainer.querySelectorAll('.combo-item');
                items.forEach((item, index) => {
                    const select = item.querySelector('select');
                    const input = item.querySelector('input[type="number"]');
                    select.name = `combo_items[${index}][id]`;
                    input.name = `combo_items[${index}][cantidad]`;
                });
                itemCount = items.length;
            }
        });
    });
</script>
@endpush