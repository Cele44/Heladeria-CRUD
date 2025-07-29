@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Dashboard
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Bienvenido al panel de administración de tu heladeria 🍦
            </p>
        </div>
    </div>

    <!-- Stats -->
    <div class="mt-8">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Pedidos -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Pedidos</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Pedido::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.pedidos.index') }}" class="font-medium text-indigo-700 hover:text-indigo-900">
                            Ver todos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Clientes -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Clientes</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Cliente::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.clientes.index') }}" class="font-medium text-green-700 hover:text-green-900">
                            Ver todos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Productos -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Productos</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Producto::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.productos.index') }}" class="font-medium text-yellow-700 hover:text-yellow-900">
                            Ver todos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ingresos del Mes -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Ingresos del Mes</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    Bs{{ number_format(\App\Models\Pedido::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total'), 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        @php
                            $currentMonth = \App\Models\Pedido::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total');
                            $previousMonth = \App\Models\Pedido::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('total');
                            $percentage = $previousMonth > 0 ? (($currentMonth - $previousMonth) / $previousMonth) * 100 : 0;
                        @endphp
                        <span class="font-medium {{ $percentage >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            {{ $percentage >= 0 ? '+' : '' }}{{ number_format($percentage, 1) }}% vs mes anterior
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Pedidos Recientes -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pedidos Recientes</h3>
                <div class="mt-5">
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse(\App\Models\Pedido::with('cliente')->latest()->take(5)->get() as $pedido)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-800">#{{ $pedido->id }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ $pedido->detalles->sum('cantidad') }} productos - €{{ number_format($pedido->total, 2) }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                            @elseif($pedido->estado == 'preparando') bg-blue-100 text-blue-800
                                            @elseif($pedido->estado == 'entregado') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="py-4">
                                <p class="text-sm text-gray-500 text-center">No hay pedidos recientes</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.pedidos.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Ver todos los pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Populares -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Productos Populares</h3>
                <div class="mt-5">
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @php
                                $productosPopulares = \App\Models\DetallePedido::select('producto_id', \DB::raw('SUM(cantidad) as total_vendido'))
                                    ->with('producto')
                                    ->groupBy('producto_id')
                                    ->orderBy('total_vendido', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            @forelse($productosPopulares as $detalle)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($detalle->producto->imagen_url)
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset($detalle->producto->imagen_url) }}" alt="{{ $detalle->producto->nombre }}">
                                        @else
                                            <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">🍦</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $detalle->producto->nombre }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ $detalle->total_vendido }} vendidos este mes
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="text-sm font-medium text-gray-900">€{{ number_format($detalle->producto->precio_base, 2) }}</span>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="py-4">
                                <p class="text-sm text-gray-500 text-center">No hay datos de productos</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.productos.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Ver todos los productos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
