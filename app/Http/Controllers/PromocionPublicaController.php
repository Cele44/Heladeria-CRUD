<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromocionPublicaController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now();

        $activas = Promocion::where('activa', true)
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->get();

        $proximas = Promocion::whereDate('fecha_inicio', '>', $hoy)->get();

        $anteriores = Promocion::whereDate('fecha_fin', '<', $hoy)->get();

        return view('user.promociones', compact('activas', 'proximas', 'anteriores'));
    }

}
