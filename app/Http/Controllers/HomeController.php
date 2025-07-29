<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Ingrediente;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('activa', true)->orderBy('orden_display')->take(6)->get();
        $ingredientes = Ingrediente::where('disponible', true)->take(6)->get();

        return view('user.home', compact('categorias', 'ingredientes'));
    }
}
