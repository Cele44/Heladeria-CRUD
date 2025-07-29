<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\FidelizacionController;
use App\Http\Controllers\Admin\IngredienteController;
use App\Http\Controllers\Admin\NotificacionController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\PromocionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PersonalizacionController;
use App\Http\Controllers\PromocionPublicaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/promociones', [PromocionPublicaController::class, 'index'])->name('promociones');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/registro', [RegisterController::class, 'showRegisterForm'])->name('registro');
Route::post('/registro', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/personalizar/{producto}', [PersonalizacionController::class, 'show'])->name('personalizar');
    Route::post('/carrito/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
    Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])->name('carrito.finalizar');
    Route::get('/mi-cuenta', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/mi-cuenta/historial', [PerfilController::class, 'historial'])->name('perfil.historial');
    Route::get('/notificaciones', [App\Http\Controllers\NotificacionController::class, 'index'])->name('notificaciones');
    Route::put('/notificaciones/{id}/leer', [App\Http\Controllers\NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcarLeida');
    Route::put('/carrito/cantidad/{index}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizarCantidad');


});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('categorias', CategoriaController::class)->names('categorias');
    Route::resource('ingredientes', IngredienteController::class)->names('ingredientes');       
    Route::resource('productos', ProductoController::class)->names('productos');
    Route::resource('clientes', ClienteController::class)->names('clientes');
    Route::resource('pedidos', PedidoController::class)->names('pedidos');
    Route::resource('promociones', PromocionController::class)
        ->names('promociones')->parameters(['promociones' => 'promocion']); 
    Route::resource('fidelizaciones', FidelizacionController::class)
        ->except(['create', 'store'])
        ->names('fidelizaciones')->parameters(['fidelizaciones' => 'fidelizacion']); 
    Route::resource('notificaciones', NotificacionController::class)
        ->names('notificaciones')->parameters(['notificaciones' => 'notificacion']); 
});

