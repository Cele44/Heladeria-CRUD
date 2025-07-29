<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Orden -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Orden de visualización *</label>
                <input type="number" name="orden_display" min="0" value="{{ old('orden_display', $categoria->orden_display ?? 1) }}" step="1" required 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('orden_display') border-red-500 @enderror">
                @error('orden_display')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Descripción -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" rows="3"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
            @error('descripcion')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Imagen actual (solo en edición) -->
        @if($isEdit && $categoria && $categoria->imagen_url)
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen actual</label>
            <div class="flex items-center space-x-4">
                <img src="{{ asset($categoria->imagen_url) }}" alt="{{ $categoria->nombre }}" 
                     class="h-20 w-20 object-cover rounded-lg border">
                <div>
                    <p class="text-sm text-gray-600">Imagen actual de la categoría</p>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="eliminar_imagen" value="1" class="mr-2">
                        <span class="text-sm text-red-600">Eliminar imagen actual</span>
                    </label>
                </div>
            </div>
        </div>
        @endif

        <!-- Nueva imagen -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                @if($isEdit && $categoria && $categoria->imagen_url)
                    Nueva imagen (opcional)
                @else
                    Imagen de la categoría
                @endif
            </label>
            <div class="flex items-center space-x-4">
                <button type="button" onclick="document.getElementById('imagenInput').click()" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Seleccionar imagen
                </button>
                <input type="file" name="imagen" id="imagenInput" accept="image/*" class="hidden @error('imagen') border-red-500 @enderror">
                <span id="fileName" class="text-sm text-gray-600"></span>
            </div>
            @error('imagen')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Estado activo -->
        <div class="mt-6">
            <div class="flex items-center">
                <label for="activa" class="block text-sm font-medium text-gray-700 mr-4">Activa:</label>
                <label for="activa" class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="activa" name="activa" value="1" class="sr-only peer"
                        {{ old('activa', $categoria->activa ?? true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
                </label>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.categorias.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ $isEdit ? 'Actualizar' : 'Crear' }} Categoría
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('imagenInput').addEventListener('change', function(e) {
    const fileName = document.getElementById('fileName');
    if (e.target.files.length > 0) {
        fileName.textContent = e.target.files[0].name;
    } else {
        fileName.textContent = '';
    }
});

// Toggle switch functionality
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.querySelector('input[name="activa"]');
    const toggle = checkbox.parentElement.querySelector('.relative');
    const dot = toggle.querySelector('.dot');
    const bg = toggle.querySelector('.block');
    
    toggle.addEventListener('click', function() {
        checkbox.checked = !checkbox.checked;
        if (checkbox.checked) {
            bg.classList.remove('bg-gray-300');
            bg.classList.add('bg-blue-500');
            dot.classList.add('transform', 'translate-x-6');
        } else {
            bg.classList.remove('bg-blue-500');
            bg.classList.add('bg-gray-300');
            dot.classList.remove('transform', 'translate-x-6');
        }
    });
});
</script>
