{{-- admin/promociones/edit.blade.php --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Promoción: {{ $promocion->nombre }}</h1>

    @include('admin.promociones._form', [
        'action' => route('admin.promociones.update', $promocion),
        'promocion' => $promocion,
        'isEdit' => true,
        'diasSemana' => $diasSemana,
        'productos' => $productos,
        'ingredientes' => $ingredientes,
        'diasSeleccionados' => $diasSeleccionados
    ])
</div>