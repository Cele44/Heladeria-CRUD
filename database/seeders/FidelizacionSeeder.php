<?php

namespace Database\Seeders;

use App\Models\Fidelizacion;
use App\Models\TransaccionPunto;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Database\Seeder;

class FidelizacionSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            $puntos = rand(0, 2000);
            
            $nivel = 'bronce';
            if ($puntos >= 1000) {
                $nivel = 'oro';
            } elseif ($puntos >= 500) {
                $nivel = 'plata';
            }

            $fidelizacion = Fidelizacion::create([
                'cliente_id' => $cliente->id,
                'puntos_acumulados' => $puntos,
                'nivel' => $nivel,
                'fecha_ultima_actualizacion' => now()->subDays(rand(0, 30)),
            ]);
if (!$fidelizacion || !$fidelizacion->id) {
    continue;
}
            // Crear algunas transacciones de puntos
            $numTransacciones = rand(3, 10);
            for ($i = 0; $i < $numTransacciones; $i++) {
                $tipo = rand(0, 1) ? 'ganado' : 'usado';
                $puntosTransaccion = $tipo === 'ganado' ? rand(10, 100) : rand(-100, -10);
                
                $motivos = [
                    'ganado' => [
                        'Compra de helados - Pedido #' . rand(1000, 9999),
                        'Bonificación por cumpleaños',
                        'Referido de amigo',
                        'Compra especial de fin de semana',
                    ],
                    'usado' => [
                        'Canje por descuento 10%',
                        'Canje por helado gratis',
                        'Canje por topping extra',
                        'Descuento en combo familiar',
                    ],
                ];
$pedidoId = $tipo === 'ganado' ? Pedido::inRandomOrder()->first()?->id : null;
    if ($tipo === 'ganado' && !$pedidoId) {
        continue;
    }
                TransaccionPunto::create([
                    'fidelizacion_id' => $fidelizacion->id,
                    'puntos' => $puntosTransaccion,
                    'tipo' => $tipo,
                    'motivo' => $motivos[$tipo][array_rand($motivos[$tipo])],
                    'fecha_transaccion' => now()->subDays(rand(0, 60)),
                    'pedido_id' => $tipo === 'ganado' ? Pedido::inRandomOrder()->first()?->id : null,
                ]);
            }
        }
    }
}
