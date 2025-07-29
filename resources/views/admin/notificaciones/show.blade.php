<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Detalles de la Notificación: {{ $notificacion->titulo }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Info izquierda --}}
            <div class="space-y-4">
                <p><span class="font-semibold text-gray-700">ID:</span> {{ $notificacion->id }}</p>
                <p><span class="font-semibold text-gray-700">Cliente:</span> {{ $notificacion->cliente->nombre }}</p>
                <p><span class="font-semibold text-gray-700">Título:</span> {{ $notificacion->titulo }}</p>
                <p><span class="font-semibold text-gray-700">Tipo:</span> {{ ucfirst(str_replace('_', ' ', $notificacion->tipo)) }}</p>
                <p><span class="font-semibold text-gray-700">Fecha envío:</span> {{ \Carbon\Carbon::parse($notificacion->fecha_envio)->format('d/m/Y') }}</p>
                <p>
                    <span class="font-semibold text-gray-700">Estado:</span>
                    <span class="px-2 py-1 rounded text-white text-xs {{ $notificacion->leida ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ $notificacion->leida ? 'Leída' : 'No leída' }}
                    </span>
                </p>
            </div>

            {{-- Mensaje --}}
            <div>
                <div class="mb-4">
                    <p class="font-semibold text-gray-700">Mensaje:</p>
                    <p class="text-gray-600 mt-2 p-3 bg-gray-50 rounded">{{ $notificacion->mensaje }}</p>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <a href="{{ route('admin.notificaciones.edit', $notificacion) }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Editar
            </a>
            <a href="{{ route('admin.notificaciones.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded hover:bg-gray-400">
                Volver
            </a>
        </div>
    </div>
</div>