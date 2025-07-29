<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        $cliente = Auth::user();

        $fidelizacion = $cliente->fidelizacion;
        $fechaRegistro = $cliente->created_at;

        // Agrega la carga de pedidos con sus detalles
        $pedidos = Pedido::with('detalles')
            ->where('cliente_id', $cliente->id)
            ->orderBy('fecha_pedido', 'desc')
            ->get();
        return view('user.perfil', compact('cliente', 'fidelizacion', 'fechaRegistro', 'pedidos'));
    }
}
