<form action="{{ $action }}" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- Nombre --}}
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
        <input type="text" name="nombre" id="nombre"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
               value="{{ old('nombre', $ingrediente->nombre ?? '') }}" required>
        @error('nombre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Descripción --}}
    <div>
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $ingrediente->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Precio Extra --}}
    <div>
        <label for="precio_extra" class="block text-sm font-medium text-gray-700">Precio Extra *</label>
        <input type="number" step="0.01" name="precio_extra" id="precio_extra" min="0"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('precio_extra') border-red-500 @enderror"
               value="{{ old('precio_extra', $ingrediente->precio_extra ?? 0) }}" required>
        @error('precio_extra')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tipo --}}
    <div>
        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo *</label>
        <select name="tipo" id="tipo"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-500 @enderror"
                required>
            <option value="">Seleccione un tipo</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo }}" {{ old('tipo', $ingrediente->tipo ?? '') == $tipo ? 'selected' : '' }}>
                    {{ ucfirst($tipo) }}
                </option>
            @endforeach
        </select>
        @error('tipo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Imagen --}}
    <div>
        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen del Producto</label>

        {{-- Mostrar imagen actual si está en modo edición y existe --}}
        @if($isEdit && !empty($ingrediente->imagen_url))
            <div class="mb-4">
                <img src="{{ asset('' . $ingrediente->imagen_url) }}" alt="Imagen actual"
                    class="w-32 h-32 object-cover rounded border border-gray-300">
            </div>
            <label for="">Nueva imagen:</label>
        @endif

        {{-- Input para cargar nueva imagen --}}
        <input type="file" name="imagen" id="imagen" accept="image/*"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Disponible --}}
    <div class="flex items-center">
        <label for="disponible" class="block text-sm font-medium text-gray-700 mr-4">Disponible:</label>
        <label for="disponible" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="disponible" name="disponible" value="1" class="sr-only peer"
                {{ old('disponible', $ingrediente->disponible ?? true) ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
            <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
        </label>
    </div>

    {{-- Botones --}}
    <div class="flex space-x-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $isEdit ? 'Actualizar Ingrediente' : 'Guardar Ingrediente' }}
        </button>

        @if (request()->ajax())
            <button type="button" @click="$dispatch('close-modal')"
                    class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
                Cancelar
            </button>
        @else
            <a href="{{ route('admin.ingredientes.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
                Cancelar
            </a>
        @endif
    </div>
</form>
