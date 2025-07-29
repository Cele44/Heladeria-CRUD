{{-- admin/productos/edit.blade.php --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Producto: {{ $producto->nombre }}</h1>

    @include('admin.productos._form', [
        'action' => route('admin.productos.update', $producto),
        'producto' => $producto,
        'isEdit' => true,
        'categorias' => $categorias,
        'ingredientes' => $ingredientes,
        'ingredientesDefecto' => $ingredientesDefecto,
        'ingredientesPersonalizados' => $ingredientesPersonalizados
    ])
</div>