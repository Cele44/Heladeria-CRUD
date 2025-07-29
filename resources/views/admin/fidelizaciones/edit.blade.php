{{-- admin/fidelizacion/edit.blade.php --}}
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Fidelización</h1>

    <form action="{{ route('admin.fidelizaciones.update', $fidelizacion) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="puntos_acumulados" class="block text-sm font-medium text-gray-700">Puntos Acumulados *</label>
            <input type="number" name="puntos_acumulados" id="puntos_acumulados" min="0" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('puntos_acumulados') border-red-500 @enderror"
                   value="{{ old('puntos_acumulados', $fidelizacion->puntos_acumulados) }}">
            @error('puntos_acumulados')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nivel" class="block text-sm font-medium text-gray-700">Nivel *</label>
            <select name="nivel" id="nivel" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nivel') border-red-500 @enderror">
                <option value="bronce" {{ old('nivel', $fidelizacion->nivel) == 'bronce' ? 'selected' : '' }}>Bronce</option>
                <option value="plata" {{ old('nivel', $fidelizacion->nivel) == 'plata' ? 'selected' : '' }}>Plata</option>
                <option value="oro" {{ old('nivel', $fidelizacion->nivel) == 'oro' ? 'selected' : '' }}>Oro</option>
            </select>
            @error('nivel')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-3">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Actualizar
            </button>
            <button type="button" @click="$dispatch('close-modal')"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded hover:bg-gray-400">
                Cancelar
            </button>
        </div>
    </form>
</div>