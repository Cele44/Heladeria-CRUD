{{-- admin/promociones/create.blade.php --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nueva Promoción</h1>

    @include('admin.promociones._form', [
        'action' => route('admin.promociones.store'),
        'promocion' => null,
        'isEdit' => false,
        'diasSemana' => $diasSemana,
        'productos' => $productos,
        'ingredientes' => $ingredientes
    ])
</div>