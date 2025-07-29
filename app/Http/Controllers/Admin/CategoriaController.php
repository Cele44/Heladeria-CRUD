<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

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
            $query->where('activa', 0);
        } elseif ($estado === '1') {
            $query->where('activa', 1);
        }

        // Ordenar por defecto
        $query->orderBy('orden_display');
        $categorias = $query->paginate(10);

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:500',
            'orden_display' => 'required|integer|min:0',
            'activa' => 'boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
            $imagenPath = $imagen->storeAs('categorias', $nombreImagen, 'public');
        }

        $categoria = Categoria::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'orden_display' => $validated['orden_display'],
            'activa' => $request->has('activa'),
            'imagen_url' => $imagenPath ? 'storage/' . $imagenPath : null
        ]);

        return redirect()->route('admin.categorias.index')
                        ->with('success', 'Categoría creada exitosamente');
    }

    public function show(Categoria $categoria)
    {
        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,'.$categoria->id,
            'descripcion' => 'nullable|string|max:500',
            'orden_display' => 'required|integer|min:0',
            'activa' => 'boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'eliminar_imagen' => 'nullable|boolean'
        ]);

        // Procesar imagen
        if($request->has('eliminar_imagen') && $request->eliminar_imagen) {
            if($categoria->imagen_url) {
                Storage::disk('public')->delete(str_replace('storage/', '', $categoria->imagen_url));
            }
            $validated['imagen_url'] = null;
        } elseif($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if($categoria->imagen_url) {
                Storage::disk('public')->delete(str_replace('storage/', '', $categoria->imagen_url));
            }
            // Guardar nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
            $validated['imagen_url'] = 'storage/' . $imagen->storeAs('categorias', $nombreImagen, 'public');
        }

        $validated['activa'] = $request->has('activa');
        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')
                        ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Categoria $categoria)
    {
        // Eliminar la imagen si existe
        if ($categoria->imagen_url) {
            Storage::disk('public')->delete(str_replace('storage/', '', $categoria->imagen_url));
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
                        ->with('success', 'Categoría eliminada correctamente');
    }
}
