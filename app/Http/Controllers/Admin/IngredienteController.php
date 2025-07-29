<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingrediente::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        $estado = $request->input('estado', '1');
        if ($estado === '0') {
            $query->where('disponible', 0);
        } elseif ($estado === '1') {
            $query->where('disponible', 1);
        }
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        // Ordenar por defecto
        $query->orderBy('created_at', 'desc');
        $ingredientes = $query->paginate(10);
        return view('admin.ingredientes.index', compact('ingredientes'));
    }

    public function create()
    {
        $tipos = Ingrediente::select('tipo')->distinct()->pluck('tipo')->filter(); // obtiene tipos únicos no nulos
        return view('admin.ingredientes.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_extra' => 'required|numeric|min:0',
            'disponible' => 'boolean',
            'tipo' => 'required|string|max:50',
            'imagen' => 'nullable|image|max:2048', 
        ]);

        $validated['disponible'] = $request->has('disponible');

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('ingredientes', 'public');
            $validated['imagen_url'] = 'storage/' . $ruta;
        }
        Ingrediente::create($validated);

        return redirect()->route('admin.ingredientes.index')
                        ->with('success', 'Ingrediente creado exitosamente');
    }

    public function show(Ingrediente $ingrediente)
    {
        return view('admin.ingredientes.show', compact('ingrediente'));
    }

    public function edit(Ingrediente $ingrediente)
    {
        $tipos = Ingrediente::select('tipo')->distinct()->pluck('tipo');
        return view('admin.ingredientes.edit', compact('ingrediente', 'tipos'));
    }

    public function update(Request $request, Ingrediente $ingrediente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_extra' => 'required|numeric|min:0',
            'disponible' => 'boolean',
            'tipo' => 'required|string|max:50',
            'imagen' => 'nullable|image|max:2048', 
        ]);

        $validated['disponible'] = $request->has('disponible');

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('ingredientes', 'public');
            $validated['imagen_url'] = 'storage/' . $ruta;
        }
        
        $ingrediente->update($validated);

        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente actualizado exitosamente');
    }

    public function destroy(Ingrediente $ingrediente)
    {
        $ingrediente->delete();
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente eliminado exitosamente');
    }
}