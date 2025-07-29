<?php
namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        $cliente = Auth::user();

        $notificaciones = Notificacion::where('cliente_id', $cliente->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.notificaciones', compact('notificaciones'));
    }
    public function marcarLeida($id)
    {
        $cliente = Auth::user();

        $notificacion = Notificacion::where('cliente_id', $cliente->id)
            ->where('notificacion_id', $id)
            ->first();

        if ($notificacion) {
            $notificacion->leida = true;
            $notificacion->save();
        }

        return redirect()->route('notificaciones');
    }
}
