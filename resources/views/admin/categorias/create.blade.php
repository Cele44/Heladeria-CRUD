{{-- admin/categorias/create.blade.php --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nueva Categoría</h1>

    @include('admin.categorias._form', [
        'action' => route('admin.categorias.store'),
        'categoria' => null,
        'isEdit' => false
    ])
</div>