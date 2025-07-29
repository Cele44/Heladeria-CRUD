{{-- admin/clientes/create.blade.php --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Cliente</h1>

    @include('admin.clientes._form', [
        'action' => route('admin.clientes.store'),
        'cliente' => null,
        'isEdit' => false
    ])
</div>