<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Ingrediente</h1>

    @include('admin.ingredientes._form', [
        'action' => route('admin.ingredientes.store'),
        'ingrediente' => null,
        'isEdit' => false,
        'tipos' => $tipos
    ])
</div>