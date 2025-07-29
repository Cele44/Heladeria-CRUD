<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nueva Notificación</h1>

    @include('admin.notificaciones._form', [
        'action' => route('admin.notificaciones.store'),
        'notificacion' => null,
        'isEdit' => false,
        'clientes' => $clientes,
        'tipos' => $tipos
    ])
</div>