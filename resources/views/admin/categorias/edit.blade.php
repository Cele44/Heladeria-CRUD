{{-- admin/categorias/edit.blade.php --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Categoría: {{ $categoria->nombre }}</h1>

    @include('admin.categorias._form', [
        'action' => route('admin.categorias.update', $categoria),
        'categoria' => $categoria,
        'isEdit' => true
    ])
</div>
