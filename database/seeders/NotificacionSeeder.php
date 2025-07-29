<?php

namespace Database\Seeders;

use App\Models\Notificacion;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        
        $notificacionesEjemplo = [
            [
                'titulo' => '¡Nueva promoción disponible!',
                'mensaje' => 'Disfruta de un 20% de descuento en tu próxima compra',
                'tipo' => 'promocion',
            ],
            [
                'titulo' => 'Tu pedido está listo',
                'mensaje' => 'El pedido está listo para recoger',
                'tipo' => 'pedido',
            ],
            [
                'titulo' => 'Nuevos sabores disponibles',
                'mensaje' => 'Prueba nuestros nuevos sabores de temporada',
                'tipo' => 'nuevo_sabor',
            ],
            [
                'titulo' => '¡Felicidades! Has subido de nivel',
                'mensaje' => 'Ahora eres cliente Oro y tienes beneficios exclusivos',
                'tipo' => 'fidelizacion',
            ],
        ];

        foreach ($clientes as $cliente) {
            // Crear 2-5 notificaciones por cliente
            $numNotificaciones = rand(2, 5);
            
            for ($i = 0; $i < $numNotificaciones; $i++) {
                $notificacion = $notificacionesEjemplo[array_rand($notificacionesEjemplo)];
                
                Notificacion::create([
                    'cliente_id' => $cliente->id,
                    'titulo' => $notificacion['titulo'],
                    'mensaje' => $notificacion['mensaje'],
                    'tipo' => $notificacion['tipo'],
                    'fecha_envio' => now()->subDays(rand(0, 30)),
                    'leida' => rand(0, 1) === 1,
                ]);
            }
        }
    }
}
