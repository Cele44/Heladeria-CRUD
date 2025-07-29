<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente']);

        // Búsqueda por nombre del cliente
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Ordenar por defecto
        $query->orderBy('created_at', 'desc');

        $pedidos = $query->paginate(10);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'detalles.producto', 'detalles.ingredientes']);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load(['cliente', 'detalles.producto']);
        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,preparando,entregado,cancelado',
            'direccion_entrega' => 'required_if:metodo_pago,efectivo,tarjeta,qr,transferencia|string|max:255',
            'metodo_pago' => 'required|in:efectivo,tarjeta,qr,transferencia',
            'notas' => 'nullable|string',
        ]);

        $pedido->update($validated);

        return redirect()->route('admin.pedidos.index')
                        ->with('success', 'Pedido actualizado correctamente');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('admin.pedidos.index')
                        ->with('success', 'Pedido eliminado correctamente');
    }
}