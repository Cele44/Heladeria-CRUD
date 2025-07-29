{{-- admin/pedidos/edit.blade.php --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Pedido #{{ $pedido->id }}</h1>

    @include('admin.pedidos._form', [
        'action' => route('admin.pedidos.update', $pedido),
        'pedido' => $pedido,
        'isEdit' => true
    ])
</div>