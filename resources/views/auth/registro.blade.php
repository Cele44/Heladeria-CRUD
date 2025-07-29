@extends('layout.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-blue-50 flex flex-col justify-center py-4 sm:py-4 px-4">
  <div class="w-full max-w-2xl mx-auto flex flex-col justify-between h-full">
    {{-- Card principal --}}
    <div class="bg-white shadow-xl rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center mb-2">Crear Cuenta</h2>
      <p class="text-center text-gray-500 mb-6">Únete a nuestra familia dulce y comienza a acumular puntos</p>

      @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
          <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('registro') }}" class="space-y-4">
        @csrf

        {{-- Nombre y Apellido --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Campo Nombre -->
          <div>
            <label for="nombre" class="block text-sm font-medium">Nombre *</label>
            <div class="relative">
              <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="pl-10 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
                    placeholder="Tu nombre" required>
              <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A12.07 12.07 0 0112 15.5c2.598 0 5.05.834 6.879 2.304M12 12a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
            </div>
          </div>

          <!-- Campo Apellido -->
          <div>
            <label for="apellido" class="block text-sm font-medium">Apellido *</label>
            <div class="relative">
              <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}"
                    class="pl-10 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Tu apellido" required>
              <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A12.07 12.07 0 0112 15.5c2.598 0 5.05.834 6.879 2.304M12 12a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
            </div>
          </div>
        </div>

        {{-- Email --}}
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium mb-1">Correo electrónico *</label>
          <div class="relative">
            <!-- Icono de email -->
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4zm0 0l8 8 8-8" />
              </svg>
            </div>
            <!-- Input -->
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                  class="pl-10 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
                  placeholder="tu@email.com" required>
          </div>
        </div>

        {{-- Teléfono --}}
        <div>
          <label for="telefono" class="block text-sm font-medium">Teléfono</label>
          <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                 class="pl-3 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
                 placeholder="+1 (555) 123-4567">
        </div>

        {{-- Dirección --}}
        <div>
          <label for="direccion" class="block text-sm font-medium">Dirección</label>
          <textarea name="direccion" id="direccion"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400 min-h-[80px]"
                    placeholder="Tu dirección completa">{{ old('direccion') }}</textarea>
        </div>

        {{-- Contraseñas --}}
        <div class="relative">
          <label for="password" class="block text-sm font-medium mb-1">Contraseña *</label>

          <input
            type="password"
            name="password"
            id="password"
            placeholder="••••••••"
            required
            class="w-full px-4 py-2 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
          >
        </div>
          <div>
            <label for="password_confirmation" class="block text-sm font-medium">Confirmar contraseña *</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-pink-400"
                   placeholder="••••••••" required>
          </div>
        </div>

        {{-- Botón --}}
        <button type="submit"
                class="w-full bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-4 py-2 rounded font-medium transition">
          Registrarse
        </button>
      </form>

      {{-- Ya tiene cuenta --}}
      <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
          ¿Ya tienes una cuenta?
          <a href="{{ route('login') }}" class="text-pink-600 hover:underline font-medium">Inicia sesión aquí</a>
        </p>
      </div>
    </div>

    {{-- Beneficios --}}
    <div class="mt-6 bg-gradient-to-r from-pink-50 to-purple-50 border border-pink-200 rounded-lg p-6 mx-auto max-w-2xl">
      <h3 class="font-semibold text-center mb-4 text-lg">🎉 ¡Beneficios de ser miembro!</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2">
          <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
          <span>15% de descuento en tu primera compra</span>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
          <span>Acumula puntos con cada compra</span>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
          <span>Promociones exclusivas para miembros</span>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
          <span>Descuento especial en tu cumpleaños</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
