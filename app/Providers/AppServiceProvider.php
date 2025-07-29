<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $cliente = Auth::user();
            $notificacionesNoLeidas = Notificacion::where('cliente_id', $cliente->id)->where('leida', false)->count();

            $view->with('notificacionesNoLeidas', $notificacionesNoLeidas);
        }
    });
    }
}
