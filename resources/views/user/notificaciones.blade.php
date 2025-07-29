@extends('layout.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 py-10">
  <div class="max-w-3xl mx-auto px-4">
    <div class="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-pink-100">
      <h2 class="text-3xl font-bold text-pink-700 mb-6 text-center">🔔 Mis Notificaciones</h2>

      @if($notificaciones->isEmpty())
        <p class="text-center text-gray-500 py-4">No tienes notificaciones por ahora.</p>
      @else
        <ul class="space-y-5">
          @foreach($notificaciones as $notificacion)
            <li class="p-5 rounded-xl shadow-md transition hover:shadow-lg border 
                       {{ !$notificacion->leida ? 'bg-yellow-50 border-yellow-200' : 'bg-white border-gray-100' }}">
              <div class="flex justify-between items-start">
                <div>
                  <p class="font-semibold text-gray-800 mb-1">{{ $notificacion->titulo }}</p>
                  <p class="text-sm text-gray-700">{{ $notificacion->mensaje }}</p>
                  <p class="text-xs text-gray-400 mt-2">{{ $notificacion->created_at->diffForHumans() }}</p>
                </div>
                @if(!$notificacion->leida)
                  <form method="POST" action="{{ route('notificaciones.marcarLeida', $notificacion->notificacion_id) }}">
                    @csrf
                    @method('PUT')
                    <button class="text-sm text-pink-600 hover:underline mt-1">Marcar como leída</button>
                  </form>
                @endif
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>
@endsection
