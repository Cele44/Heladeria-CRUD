{{-- admin/productos/_form.blade.php --}}
<form action="{{ $action }}" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- Nombre --}}
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
        <input type="text" name="nombre" id="nombre" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
               value="{{ old('nombre', $producto->nombre ?? '') }}">
        @error('nombre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Descripción --}}
    <div>
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Categoría --}}
    <div>
        <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
        <select name="categoria_id" id="categoria_id" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('categoria_id') border-red-500 @enderror">
            <option value="">Seleccione una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @error('categoria_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Precio Base --}}
        <div>
            <label for="precio_base" class="block text-sm font-medium text-gray-700">Precio Base *</label>
            <input type="number" step="0.01" name="precio_base" id="precio_base" min="0" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('precio_base') border-red-500 @enderror"
                   value="{{ old('precio_base', $producto->precio_base ?? 0) }}">
            @error('precio_base')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tiempo Preparación --}}
        <div>
            <label for="tiempo_preparacion" class="block text-sm font-medium text-gray-700">Tiempo Preparación (min)</label>
            <input type="number" name="tiempo_preparacion" id="tiempo_preparacion" min="0"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tiempo_preparacion') border-red-500 @enderror"
                   value="{{ old('tiempo_preparacion', $producto->tiempo_preparacion ?? '') }}">
            @error('tiempo_preparacion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Imagen --}}
    <div>
        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen del Producto</label>
        
        @if($isEdit && $producto->imagen_url)
            <div class="mb-4">
                <img src="{{ asset($producto->imagen_url) }}" alt="Imagen actual del producto"
                    class="w-32 h-32 object-cover rounded border border-gray-300">
            </div>
            <label class="text-sm text-gray-600">Nueva imagen (opcional):</label>
        @endif

        <input type="file" name="imagen" id="imagen" accept="image/*"
               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('imagen') border-red-500 @enderror">
        @error('imagen')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Disponible --}}
        <div class="flex items-center">
            <label for="disponible" class="block text-sm font-medium text-gray-700 mr-4">Disponible:</label>
            <label for="disponible" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="disponible" name="disponible" value="1" class="sr-only peer"
                    {{ old('disponible', $producto->disponible ?? true) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
            </label>
        </div>

        {{-- Es Personalizable --}}
        <div class="flex items-center">
            <label for="es_personalizado" class="block text-sm font-medium text-gray-700 mr-4">Personalizable:</label>
            <label for="es_personalizado" class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="es_personalizado" value="0">
                <input type="checkbox" id="es_personalizado" name="es_personalizado" value="1" class="sr-only peer"
                    {{ old('es_personalizado', $producto->es_personalizado ?? false) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
            </label>
        </div>
    </div>

    {{-- Ingredientes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Ingredientes por defecto --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ingredientes por defecto</label>
            @foreach($ingredientes as $tipo => $grupo)
                <div class="mb-2">
                    <p class="text-sm font-semibold text-gray-600 mb-1">{{ $tipo }}</p>
                    @foreach($grupo as $ingrediente)
                        <div class="flex items-center ml-2 mb-1">
                            <input type="checkbox" name="ingredientes_defecto[]" 
                                   id="ingrediente_defecto_{{ $ingrediente->id }}"
                                   value="{{ $ingrediente->id }}"
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('ingredientes_defecto') border-red-500 @enderror"
                                   @if(in_array($ingrediente->id, old('ingredientes_defecto', $ingredientesDefecto ?? []))) checked @endif>
                            <label for="ingrediente_defecto_{{ $ingrediente->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $ingrediente->nombre }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- Ingredientes personalizables --}}
        <div id="ingredientes_personalizados_container" class="{{ old('es_personalizado', $producto->es_personalizado ?? false) ? '' : 'hidden' }}">
            <label class="block text-sm font-medium text-gray-700 mb-2">Ingredientes personalizables</label>
            @foreach($ingredientes as $tipo => $grupo)
                <div class="mb-2">
                    <p class="text-sm font-semibold text-gray-600 mb-1">{{ $tipo }}</p>
                    @foreach($grupo as $ingrediente)
                        <div class="flex items-center ml-2 mb-1">
                            <input type="checkbox" name="ingredientes_personalizados[]" 
                                   id="ingrediente_personalizado_{{ $ingrediente->id }}"
                                   value="{{ $ingrediente->id }}"
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 @error('ingredientes_personalizados') border-red-500 @enderror"
                                   @if(in_array($ingrediente->id, old('ingredientes_personalizados', $ingredientesPersonalizados ?? []))) checked @endif>
                            <label for="ingrediente_personalizado_{{ $ingrediente->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $ingrediente->nombre }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    {{-- Botones --}}
    <div class="flex space-x-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $isEdit ? 'Actualizar Producto' : 'Crear Producto' }}
        </button>

        <a href="{{ $isEdit ? route('admin.productos.show', $producto) : route('admin.productos.index') }}"
           class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
            Cancelar
        </a>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('es_personalizado');
        const container = document.getElementById('ingredientes_personalizados_container');

        checkbox.addEventListener('change', function() {
            container.classList.toggle('hidden', !this.checked);
        });
    });
</script>
@endpush