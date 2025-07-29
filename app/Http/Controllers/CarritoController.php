<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\DetallePedidoIngrediente;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function agregar(Request $request, $id)
    {
        $producto = Producto::with('ingredientes')->findOrFail($id);
        $usuarioId = Auth::id();

        // Validar los datos
        $data = $request->validate([
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
            'nota' => 'nullable|string|max:255',
        ]);

        // Calcular precio total
        $precioTotal = $producto->precio_base;
        $ingredientesExtras = [];

        if (!empty($data['ingredientes'])) {
            foreach ($producto->ingredientes as $ingrediente) {
                if (
                    !$ingrediente->pivot->es_default &&
                    in_array($ingrediente->id, $data['ingredientes'])
                ) {
                    $precioTotal += $ingrediente->precio_extra;
                    $ingredientesExtras[] = [
                        'id' => $ingrediente->id,
                        'nombre' => $ingrediente->nombre,
                        'precio_extra' => $ingrediente->precio_extra,
                    ];
                }
            }
        }

        // Armar estructura de carrito
        $item = [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'imagen_url' => $producto->imagen_url,
            'precio_base' => $producto->precio_base,
            'precio_total' => $precioTotal,
            'ingredientes_extra' => $ingredientesExtras,
            'nota' => $data['nota'] ?? '',
        ];

        // Guardar en sesión por usuario
        $carrito = session()->get("carrito.$usuarioId", []);
        $carrito[] = $item;

        session()->put("carrito.$usuarioId", $carrito);

        return redirect()->route('menu')->with('success', 'Producto agregado al carrito 🛒');
    }
    public function ver()
    {
        $usuarioId = Auth::id();
        $carrito = session("carrito.$usuarioId", []);
        $cantidadCarrito = count($carrito);

        return view('user.carrito', compact('carrito', 'cantidadCarrito'));
    }

    public function finalizar(Request $request)
    {
        $usuario = Auth::user();
        $usuarioId = $usuario->id;
        $carrito = session("carrito.$usuarioId", []);

        if (empty($carrito)) {
            return redirect()->route('carrito.ver')->with('error', 'Tu carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'cliente_id' => $usuarioId,
                'fecha_pedido' => now(),
                'estado' => 'pendiente', // Podés usar un enum o string
                'total' => collect($carrito)->sum('precio_total'),
                'direccion_entrega' => $usuario->direccion ?? 'Retiro en local',
                'metodo_pago' => 'efectivo', // O lo que elijas más adelante
                'notas' => null,
            ]);

            // Recorrer los ítems del carrito
           foreach ($carrito as $item) {
                $cantidad = $item['cantidad'] ?? 1;

                $detalle = DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $item['precio_base'],
                    'subtotal' => $item['precio_total'] * $cantidad,
                    'instrucciones_especiales' => $item['nota'] ?? null,
                    'promocion_id' => null,
                ]);

                // Ingredientes extra
                if (!empty($item['ingredientes_extra'])) {
                    foreach ($item['ingredientes_extra'] as $ingrediente) {
                        DetallePedidoIngrediente::create([
                            'detalle_id' => $detalle->id,
                            'ingrediente_id' => $ingrediente['id'],
                            'es_extra' => true,
                        ]);
                    }
                }
            }


            DB::commit();

            // Limpiar carrito
            session()->forget("carrito.$usuarioId");

            return redirect()->route('user.home')->with('success', 'Pedido finalizado con éxito 🧾');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Hubo un problema al finalizar tu pedido 😢');
        }
    }
    public function actualizarCantidad(Request $request, $index)
    {
        $usuarioId = Auth::id();
        $carrito = session("carrito.$usuarioId", []);

        if (!isset($carrito[$index])) {
            return back()->with('error', 'Producto no encontrado en el carrito.');
        }

        $accion = $request->input('accion');

        if (!isset($carrito[$index]['cantidad'])) {
            $carrito[$index]['cantidad'] = 1;
        }

        if ($accion === 'sumar') {
            $carrito[$index]['cantidad']++;
        } elseif ($accion === 'restar') {
            $carrito[$index]['cantidad']--;
            if ($carrito[$index]['cantidad'] < 1) {
                unset($carrito[$index]); // Eliminar si baja de 1
                session()->put("carrito.$usuarioId", array_values($carrito));
                return back()->with('info', 'Producto eliminado del carrito.');
            }
        }

        session()->put("carrito.$usuarioId", $carrito);
        return back();
    }

}
