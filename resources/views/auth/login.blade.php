@extends('layout.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-blue-50 flex justify-center py-3 sm:py-16 px-4">
  <div class="w-full max-w-md">
    {{-- Logo --}}
    <div class="text-center mb-8">
      <a href="/" class="inline-flex items-center space-x-2">
        {{-- Cambiá esto por el SVG o imagen que uses --}}
        <svg class="h-10 w-10 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M12 2C8 2 4 6 4 10s4 8 8 8 8-4 8-8-4-8-8-8z" />
        </svg>
        <span class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
          Heladería Dulce
        </span>
      </a>
    </div>

    {{-- Card de login --}}
    <div class="bg-white rounded-xl shadow-xl p-6 border border-pink-100">
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Iniciar Sesión</h2>
        <p class="text-sm text-gray-500">Ingresa a tu cuenta para disfrutar de todos los beneficios</p>
      </div>

      {{-- Mostrar errores --}}
      @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 text-sm px-4 py-2 rounded mb-4">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <div class="relative mt-1">
            <input
              id="email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
              placeholder="tu@email.com"
            />
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M16 4H8a4 4 0 00-4 4v8a4 4 0 004 4h8a4 4 0 004-4V8a4 4 0 00-4-4z" />
              <path d="M22 6l-10 7L2 6" />
            </svg>
          </div>
        </div>

        {{-- Password --}}
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <div class="relative mt-1">
            <input
              id="password"
              type="password"
              name="password"
              required
              class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
              placeholder="••••••••"
            />
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M12 17a2 2 0 002-2v-2a2 2 0 10-4 0v2a2 2 0 002 2z" />
              <path d="M5 10V8a7 7 0 0114 0v2" />
              <path d="M5 10h14v10H5z" />
            </svg>
          </div>
        </div>

        {{-- Botón --}}
        <button
          type="submit"
          class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-2 px-4 rounded hover:opacity-90 transition"
        >
          Iniciar Sesión
        </button>
      </form>

      {{-- Registro --}}
      <div class="mt-6 text-center text-sm text-gray-600">
        ¿No tienes una cuenta?
        <a href="{{ route('registro') }}" class="text-pink-600 hover:underline font-medium">Regístrate aquí</a>
      </div>
    </div>

    {{-- Beneficios --}}
    <div class="bg-gradient-to-r from-pink-50 to-purple-50 border border-pink-200 rounded-lg mt-6 p-4 text-sm text-gray-700">
      <h3 class="font-semibold text-center mb-3">¿Por qué crear una cuenta?</h3>
      <ul class="space-y-2">
        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-pink-500 rounded-full"></span>Acumula puntos con cada compra</li>
        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-purple-500 rounded-full"></span>Acceso a promociones exclusivas</li>
        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-pink-500 rounded-full"></span>Historial de pedidos y favoritos</li>
        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-purple-500 rounded-full"></span>Descuentos especiales en tu cumpleaños</li>
      </ul>
    </div>
  </div>
</div>
@endsection
