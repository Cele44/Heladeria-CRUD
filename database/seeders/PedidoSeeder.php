<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $promociones = Promocion::all();
        $ingredientes = Ingrediente::all();

        // Crear pedidos específicos basados en los ejemplos del frontend
        $pedidosEjemplo = [
            [
                'cliente_nombre' => 'María González',
                'estado' => 'pendiente',
                'total' => 24.99,
                'metodo_pago' => 'tarjeta',
                'notas' => 'Sin nueces por favor',
                'detalles' => [
                    [
                        'producto_nombre' => 'Helado de Vainilla',
                        'cantidad' => 2,
                        'precio_unitario' => 5.99,
                        'instrucciones' => 'Extra cremoso',
                        'ingredientes_extra' => [1], // Chispas de chocolate
                    ],
                    [
                        'producto_nombre' => 'Sundae Especial',
                        'cantidad' => 1,
                        'precio_unitario' => 8.99,
                        'promocion' => 'primera_compra',
                        'ingredientes_extra' => [17, 15], // Almendras, Cerezas
                    ],
                ],
            ],
            [
                'cliente_nombre' => 'Juan Pérez',
                'estado' => 'preparando',
                'total' => 18.50,
                'metodo_pago' => 'efectivo',
                'detalles' => [
                    [
                        'producto_nombre' => 'Helado de Chocolate',
                        'cantidad' => 1,
                        'precio_unitario' => 6.99,
                        'instrucciones' => 'Doble chocolate',
                        'ingredientes_extra' => [12], // Salsa de chocolate
                    ],
                    [
                        'producto_nombre' => 'Helado de Vainilla',
                        'cantidad' => 2,
                        'precio_unitario' => 5.99,
                    ],
                ],
            ],
        ];

        foreach ($pedidosEjemplo as $pedidoData) {
            $cliente = $clientes->where('nombre', explode(' ', $pedidoData['cliente_nombre'])[0])->first();
            if (!$cliente) continue;

            $pedido = Pedido::create([
                'cliente_id' => $cliente->id,
                'fecha_pedido' => now()->subDays(rand(0, 30)),
                'estado' => $pedidoData['estado'],
                'total' => $pedidoData['total'],
                'direccion_entrega' => $cliente->direccion,
                'metodo_pago' => $pedidoData['metodo_pago'],
                'notas' => $pedidoData['notas'] ?? null,
            ]);

            foreach ($pedidoData['detalles'] as $detalleData) {
                $producto = $productos->where('nombre', $detalleData['producto_nombre'])->first();
                if (!$producto) continue;

                $promocion = null;
                if (isset($detalleData['promocion'])) {
                    $promocion = $promociones->where('tipo', $detalleData['promocion'])->first();
                }

                $detalle = DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $detalleData['cantidad'],
                    'precio_unitario' => $detalleData['precio_unitario'],
                    'subtotal' => $detalleData['cantidad'] * $detalleData['precio_unitario'],
                    'instrucciones_especiales' => $detalleData['instrucciones'] ?? null,
                    'promocion_id' => $promocion?->id,
                ]);

                // Agregar ingredientes extra
                if (isset($detalleData['ingredientes_extra'])) {
                    foreach ($detalleData['ingredientes_extra'] as $ingredienteId) {
                        $detalle->ingredientes()->attach($ingredienteId, ['es_extra' => true]);
                    }
                }
            }
        }

        // Crear pedidos adicionales aleatorios
    }
}
