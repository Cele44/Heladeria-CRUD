<div 
    x-data="{ open: false, form: null }" 
    x-on:open-delete-modal.window="open = true; form = $event.detail.form" 
    x-show="open" 
    class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-md z-40"
    x-cloak
>
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-sm">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">¿Estás seguro?</h2>
        <p class="text-gray-600 mb-6">Esta acción eliminará el ingrediente permanentemente. ¿Deseas continuar?</p>

        <div class="flex justify-end space-x-3">
            <button 
                @click="open = false" 
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-sm">
                Cancelar
            </button>
            <button 
                @click="form.submit()" 
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
