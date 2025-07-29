<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categoriaId = $request->query('categoria');
        $buscar = $request->query('buscar');

        $categorias = Categoria::all();

        $productos = Producto::with('categoria')
            ->when($categoriaId, fn($q) => $q->where('categoria_id', $categoriaId))
            ->when($buscar, fn($q) => $q->where('nombre', 'like', '%' . $buscar . '%'))
            ->where('disponible', true)
            ->get();

        return view('user.menu', compact('productos', 'categorias', 'categoriaId', 'buscar'));
    }
}
