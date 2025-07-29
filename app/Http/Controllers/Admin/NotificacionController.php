<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Notificacion::with('cliente');

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        $estado = $request->input('estado', '1');
        if ($estado === '0') {
            $query->where('leida', 0);
        } elseif ($estado === '1') {
            $query->where('leida', 1);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        // Ordenar por defecto
        $query->orderBy('created_at', 'desc');

        $notificaciones = $query->paginate(10);
        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $tipos = ['promocion', 'nuevo_sabor', 'pedido', 'fidelizacion'];
        return view('admin.notificaciones.create', compact('clientes', 'tipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|in:promocion,nuevo_sabor,pedido,fidelizacion',
            'leida' => 'boolean',
        ]);

        $validated['leida'] = $request->has('leida');

        Notificacion::create($validated);

        return redirect()->route('admin.notificaciones.index')
                        ->with('success', 'Notificación creada exitosamente');
    }

    public function show(Notificacion $notificacion)
    {
        return view('admin.notificaciones.show', compact('notificacion'));
    }

    public function edit(Notificacion $notificacion)
    {
        $clientes = Cliente::all();
        $tipos = ['promocion', 'nuevo_sabor', 'pedido', 'fidelizacion'];
        return view('admin.notificaciones.edit', compact('notificacion', 'clientes', 'tipos'));
    }

    public function update(Request $request, Notificacion $notificacion)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|in:promocion,nuevo_sabor,pedido,fidelizacion',
            'leida' => 'boolean',
        ]);

        $validated['leida'] = $request->has('leida');

        $notificacion->update($validated);

        return redirect()->route('admin.notificaciones.index')
                        ->with('success', 'Notificación actualizada exitosamente');
    }

    public function destroy(Notificacion $notificacion)
    {
        $notificacion->delete();
        return redirect()->route('admin.notificaciones.index')
                        ->with('success', 'Notificación eliminada exitosamente');
    }
}