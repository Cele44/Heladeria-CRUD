{{-- admin/clientes/_form.blade.php --}}
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
               value="{{ old('nombre', $cliente->nombre ?? '') }}" required>
        @error('nombre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Apellido --}}
    <div>
        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido *</label>
        <input type="text" name="apellido" id="apellido"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('apellido') border-red-500 @enderror"
               value="{{ old('apellido', $cliente->apellido ?? '') }}" required>
        @error('apellido')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
        <input type="email" name="email" id="email"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
               value="{{ old('email', $cliente->email ?? '') }}" required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Teléfono --}}
    <div>
        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('telefono') border-red-500 @enderror"
               value="{{ old('telefono', $cliente->telefono ?? '') }}">
        @error('telefono')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Dirección --}}
    <div>
        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
        <textarea name="direccion" id="direccion" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $cliente->direccion ?? '') }}</textarea>
        @error('direccion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Password --}}
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">
            {{ $isEdit ? 'Nueva Contraseña (dejar en blanco para no cambiar)' : 'Contraseña *' }}
        </label>
        <input type="password" name="password" id="password"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
               {{ $isEdit ? '' : 'required' }}>
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Password Confirmation --}}
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
            {{ $isEdit ? 'Confirmar Nueva Contraseña' : 'Confirmar Contraseña *' }}
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password_confirmation') border-red-500 @enderror"
               {{ $isEdit ? '' : 'required' }}>
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Activo --}}
    <div class="flex items-center">
        <label for="activo" class="block text-sm font-medium text-gray-700 mr-4">Estado:</label>
        <label for="activo" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="activo" name="activo" value="1" class="sr-only peer"
                {{ old('activo', $cliente->activo ?? true) ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
            <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
        </label>
    </div>

    {{-- Botones --}}
    <div class="flex space-x-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $isEdit ? 'Actualizar Cliente' : 'Guardar Cliente' }}
        </button>

        @if (request()->ajax())
            <button type="button" @click="$dispatch('close-modal')"
                    class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
                Cancelar
            </button>
        @else
            <a href="{{ route('admin.clientes.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
                Cancelar
            </a>
        @endif
    </div>
</form>