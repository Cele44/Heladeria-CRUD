<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- Cliente --}}
    <div>
        <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente *</label>
        <select name="cliente_id" id="cliente_id" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
            <option value="">Seleccione un cliente</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id', $notificacion->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->nombre }}
                </option>
            @endforeach
        </select>
        @error('cliente_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Título --}}
    <div>
        <label for="titulo" class="block text-sm font-medium text-gray-700">Título *</label>
        <input type="text" name="titulo" id="titulo" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('titulo') border-red-500 @enderror"
               value="{{ old('titulo', $notificacion->titulo ?? '') }}">
        @error('titulo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Mensaje --}}
    <div>
        <label for="mensaje" class="block text-sm font-medium text-gray-700">Mensaje *</label>
        <textarea name="mensaje" id="mensaje" rows="4" required
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('mensaje') border-red-500 @enderror">{{ old('mensaje', $notificacion->mensaje ?? '') }}</textarea>
        @error('mensaje')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tipo --}}
    <div>
        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo *</label>
        <select name="tipo" id="tipo" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-500 @enderror">
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo }}" {{ old('tipo', $notificacion->tipo ?? '') == $tipo ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                </option>
            @endforeach
        </select>
        @error('tipo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Leída --}}
    <div class="flex items-center">
        <label for="leida" class="block text-sm font-medium text-gray-700 mr-4">Leída:</label>
        <label for="leida" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="leida" name="leida" value="1" class="sr-only peer"
                {{ old('leida', $notificacion->leida ?? false) ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
            <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
        </label>
    </div>

    {{-- Botones --}}
    <div class="flex space-x-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $isEdit ? 'Actualizar Notificación' : 'Crear Notificación' }}
        </button>
        <a href="{{ route('admin.notificaciones.index') }}"
           class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
            Cancelar
        </a>
    </div>
</form>