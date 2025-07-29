<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

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

        $query->orderBy('created_at', 'desc');

        $productos = $query->paginate(10);
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all()->groupBy('tipo');
        return view('admin.productos.create', compact('categorias', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_base' => 'required|numeric|min:0',
            'tiempo_preparacion' => 'nullable|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'disponible' => 'boolean',
            'es_personalizado' => 'boolean',
            'ingredientes_defecto' => 'nullable|array',
            'ingredientes_defecto.*' => 'exists:ingredientes,id',
            'ingredientes_personalizados' => 'nullable|array',
            'ingredientes_personalizados.*' => 'exists:ingredientes,id',
        ]);

        $validated['disponible'] = $request->has('disponible');
        $validated['es_personalizado'] = $request->has('es_personalizado');

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');
            $validated['imagen_url'] = 'storage/' . $ruta;
        }

        $producto = Producto::create($validated);

        // Sincronizar ingredientes
        $ingredientes = [];
        foreach ($request->input('ingredientes_defecto', []) as $id) {
            $ingredientes[$id] = ['es_default' => true];
        }

        if ($request->has('es_personalizado')) {
            foreach ($request->input('ingredientes_personalizados', []) as $id) {
                $ingredientes[$id] = ['es_default' => false];
            }
        }

        $producto->ingredientes()->sync($ingredientes);

        return redirect()->route('admin.productos.index')
                        ->with('success', 'Producto creado correctamente');
    }

    public function show(Producto $producto)
    {
        $producto->load(['categoria', 'ingredientes']);
        return view('admin.productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all()->groupBy('tipo');
        $ingredientesDefecto = $producto->ingredientes()->wherePivot('es_default', true)->pluck('id')->toArray();
        $ingredientesPersonalizados = $producto->ingredientes()->wherePivot('es_default', false)->pluck('id')->toArray();
        
        return view('admin.productos.edit', compact(
            'producto', 
            'categorias', 
            'ingredientes',
            'ingredientesDefecto',
            'ingredientesPersonalizados'
        ));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_base' => 'required|numeric|min:0',
            'tiempo_preparacion' => 'nullable|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'disponible' => 'boolean',
            'es_personalizado' => 'boolean',
            'ingredientes_defecto' => 'nullable|array',
            'ingredientes_defecto.*' => 'exists:ingredientes,id',
            'ingredientes_personalizados' => 'nullable|array',
            'ingredientes_personalizados.*' => 'exists:ingredientes,id',
        ]);

        $validated['disponible'] = $request->has('disponible');
        $validated['es_personalizado'] = $request->has('es_personalizado');

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');
            $validated['imagen_url'] = 'storage/' . $ruta;
        }

        $producto->update($validated);

        // Sincronizar ingredientes
        $ingredientes = [];
        foreach ($request->input('ingredientes_defecto', []) as $id) {
            $ingredientes[$id] = ['es_default' => true];
        }

        if ($request->has('es_personalizado')) {
            foreach ($request->input('ingredientes_personalizados', []) as $id) {
                $ingredientes[$id] = ['es_default' => false];
            }
        }

        $producto->ingredientes()->sync($ingredientes);

        return redirect()->route('admin.productos.index')
                        ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.index')
                        ->with('success', 'Producto eliminado correctamente');
    }
}