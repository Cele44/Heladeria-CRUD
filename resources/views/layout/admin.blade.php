<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 text-gray-800">
    @include('components.toast')
    <!-- Menú top -->
    <nav class="flex justify-between items-center bg-gray-800 text-white px-6 py-4 shadow">
        <h1 class="text-lg font-semibold">Panel de administración</h1>
        <div class="flex gap-2">
            <a href="{{ url()->current() }}" class="bg-gray-600 hover:bg-gray-700 px-3 py-1 rounded text-sm">
                🔄 Actualizar
            </a>
            <a href="{{ url('/') }}" class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm" target="_blank">
                🛍️ Ver tienda
            </a>
        </div>
    </nav>
    <!-- Menú horizontal secundario -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <ul class="flex gap-6 px-6 py-3 text-sm font-medium text-gray-700">
            <li><a href="/admin" class="hover:text-blue-600">Dashboard</a></li>
            <li><a href="{{ route('admin.clientes.index') }}" class="hover:text-blue-600">Clientes</a></li>
            <li><a href="{{ route('admin.pedidos.index') }}" class="hover:text-blue-600">Pedidos</a></li>
            <li><a href="{{ route('admin.productos.index') }}" class="hover:text-blue-600">Productos</a></li>
            <li><a href="{{ route('admin.categorias.index') }}" class="hover:text-blue-600">Categorías</a></li>
            <li><a href="{{ route('admin.ingredientes.index') }}" class="hover:text-blue-600">Ingredientes</a></li>
            <li><a href="{{ route('admin.promociones.index') }}" class="hover:text-blue-600">Promociones</a></li>
            <li><a href="{{ route('admin.fidelizaciones.index') }}" class="hover:text-blue-600">Fidelización</a></li>
            <li><a href="{{ route('admin.notificaciones.index') }}" class="hover:text-blue-600">Notificaciones</a></li>
        </ul>
    </nav>

    <!-- Contenido -->
    <main class="p-6">
        @yield('content')
    </main>
    
    @stack('scripts')
    @yield('scripts')

</body>
</html>
