<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        $activo = $request->input('activo', '1');
        if ($activo === '0') {
            $query->where('activo', 0);
        } elseif ($activo === '1') {
            $query->where('activo', 1);
        }

        // Ordenar por defecto
        $query->orderBy('created_at', 'desc');
        $clientes = $query->paginate(10);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'activo' => 'boolean',
        ]);

        $validated['password_hash'] = Hash::make($validated['password']);
        $validated['activo'] = $request->has('activo');

        Cliente::create($validated);
        
        return redirect()->route('admin.clientes.index')
                        ->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('clientes')->ignore($cliente->id),
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'activo' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password_hash'] = Hash::make($validated['password']);
        }

        $validated['activo'] = $request->has('activo');
        $cliente->update($validated);

        return redirect()->route('admin.clientes.index')
                        ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')
                        ->with('success', 'Cliente eliminado correctamente');
    }
}