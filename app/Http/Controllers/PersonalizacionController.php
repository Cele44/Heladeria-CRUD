<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class PersonalizacionController extends Controller
{
    public function show($id)
    {
        $producto = Producto::with('ingredientes')->findOrFail($id);

        return view('user.personalizar', compact('producto'));
    }
}
