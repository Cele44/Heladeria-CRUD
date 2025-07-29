<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Heladería Dulce Nieve</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>

</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <header class="bg-pink-200 shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 py-4 flex flex-wrap justify-between items-center">
        <!-- Logo y nombre -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-pink-700 hover:text-pink-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 2L4 10h3v8h10v-8h3l-8-8z" />
            </svg>
            <span class="text-xl font-extrabold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                Heladería Dulce
            </span>
        </a>

        <!-- Navegación principal -->
        <nav class="flex items-center space-x-6 text-sm font-medium text-pink-800">
            <a href="/" class="hover:text-pink-600 transition">Inicio</a>
            <a href="/menu" class="hover:text-pink-600 transition">Menú</a>
            <a href="/promociones" class="hover:text-pink-600 transition">Promociones</a>
        </nav>

        <!-- Iconos y cuenta -->
        <div class="flex items-center gap-4 text-pink-800 text-xl">
            @auth
                <!-- Notificaciones -->
                <a href="{{ route('notificaciones') }}" class="relative hover:text-pink-600">
                    🔔
                    @if (isset($notificacionesNoLeidas) && $notificacionesNoLeidas > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                            {{ $notificacionesNoLeidas }}
                        </span>
                    @endif
                </a>

                <!-- Carrito -->
                <a href="{{ route('carrito.ver') }}" class="relative hover:text-pink-600">
                    🛒
                    @if (session()->has("carrito." . Auth::id()))
                        <?php $carrito = session("carrito." . Auth::id()); ?>
                        @if (count($carrito) > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                                {{ count($carrito) }}
                            </span>
                        @endif
                    @endif
                </a>
            @endauth

            <!-- Sesión -->
            @guest
                <a href="/login" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-1.5 rounded-full text-sm transition">
                    Iniciar sesión
                </a>
            @endguest

            @auth
                <!-- Menú desplegable -->
                <div x-data="{ open: false }" class="relative text-sm" x-cloak>
                    <button @click="open = !open" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-1.5 rounded-full transition">
                        Mi cuenta
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg border border-gray-200 z-50"
                         style="display: none;">
                        <ul class="py-2">
                            <li>
                                <a href="{{ route('perfil') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Ver cuenta</a>
                            </li>
                            <li>
                                <form action="/logout" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    @include('components.toast')
</header>


    <!-- Main -->
    <main class="flex-1 container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-pink-200 text-pink-800 py-8 mt-8">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
            <!-- Branding -->
            <div>
                <h2 class="text-xl font-bold mb-2">Heladería Dulce Nieve</h2>
                <p class="text-sm">Sabor artesanal desde 1998 🍦</p>
            </div>

            <!-- Enlaces rápidos -->
            <div>
                <h3 class="font-semibold mb-2">Enlaces</h3>
                <ul class="text-sm space-y-1">
                    <li><a href="/" class="hover:underline">Inicio</a></li>
                    <li><a href="/menu" class="hover:underline">Menú</a></li>
                    <li><a href="/promociones" class="hover:underline">Promociones</a></li>
                    <li><a href="/contacto" class="hover:underline">Contacto</a></li>
                </ul>
            </div>

            <!-- Redes sociales -->
            <div>
                <h3 class="font-semibold mb-2">Síguenos</h3>
                <div class="flex justify-center md:justify-start space-x-4 text-2xl">
                    <a href="#" class="hover:text-pink-600">📸</a>
                    <a href="#" class="hover:text-pink-600">📘</a>
                    <a href="#" class="hover:text-pink-600">🐦</a>
                    <a href="#" class="hover:text-pink-600">📱</a>
                </div>
            </div>
        </div>

        <div class="text-center text-sm mt-6 border-t border-pink-300 pt-4">
            © {{ date('Y') }} Heladería Dulce Nieve. Todos los derechos reservados.
        </div>
    </footer>
    @yield('scripts')
</body>
</html>
