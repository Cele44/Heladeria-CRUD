<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Notificación: {{ $notificacion->titulo }}</h1>

    @include('admin.notificaciones._form', [
        'action' => route('admin.notificaciones.update', $notificacion),
        'notificacion' => $notificacion,
        'isEdit' => true,
        'clientes' => $clientes,
        'tipos' => $tipos
    ])
</div>