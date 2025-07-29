<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fidelizacion;
use App\Models\Cliente;
use Illuminate\Http\Request;

class FidelizacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Fidelizacion::with('cliente');

        // Búsqueda por nombre del cliente
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('nivel')) {
            $query->where('nivel', $request->input('nivel'));
        }

        // Ordenar por defecto
        $query->orderBy('id');

        $fidelizaciones = $query->paginate(10);

        return view('admin.fidelizaciones.index', compact('fidelizaciones'));
    }

    public function show(Fidelizacion $fidelizacion)
    {
        $fidelizacion->load(['cliente', 'transacciones' => function($query) {
            $query->latest()->take(10);
        }]);
        
        return view('admin.fidelizaciones.show', compact('fidelizacion'));
    }

    public function edit(Fidelizacion $fidelizacion)
    {
        return view('admin.fidelizaciones.edit', compact('fidelizacion'));
    }

    public function update(Request $request, Fidelizacion $fidelizacion)
    {
        $validated = $request->validate([
            'puntos_acumulados' => 'required|integer|min:0',
            'nivel' => 'required|in:bronce,plata,oro',
        ]);

        $validated['fecha_ultima_actualizacion'] = now();

        $fidelizacion->update($validated);

        return redirect()->route('admin.fidelizaciones.index')
                        ->with('success', 'Programa de fidelización actualizado correctamente');
    }

    public function destroy(Fidelizacion $fidelizacion)
    {
        $fidelizacion->delete();
        return redirect()->route('admin.fidelizaciones.index')
                        ->with('success', 'Registro de fidelización eliminado correctamente');
    }
}