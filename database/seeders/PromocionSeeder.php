<?php

namespace Database\Seeders;

namespace Database\Seeders;

use App\Models\Promocion;
use Illuminate\Database\Seeder;

class PromocionSeeder extends Seeder
{
    public function run(): void
    {
        $promociones = [
            [
                'nombre' => 'Martes de Doble Delicia',
                'descripcion' => '2x1 en conos o copas todos los martes y jueves. ¡Doble placer, mismo precio!',
                'tipo' => '2x1',
                'descuento_porcentaje' => 50.00,
                'fecha_inicio' => '2024-01-01 00:00:00',
                'fecha_fin' => '2024-12-31 23:59:59',
                'dias_aplicables' => json_encode(['martes', 'jueves']),
                'activa' => true,
            ],
            [
                'nombre' => '¡Tu primer helado va por la casa (casi)!',
                'descripcion' => '15% de descuento en tu primera compra. Bienvenido a la familia heladera más dulce.',
                'tipo' => 'primera_compra',
                'descuento_porcentaje' => 15.00,
                'fecha_inicio' => '2024-01-01 00:00:00',
                'fecha_fin' => '2024-12-31 23:59:59',
                'dias_aplicables' => json_encode(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo']),
                'activa' => true,
            ],
            [
                'nombre' => 'Happy Hour Helado',
                'descripcion' => '20% de descuento de 3 PM a 5 PM. ¡La hora más dulce del día!',
                'tipo' => 'happy_hour',
                'descuento_porcentaje' => 20.00,
                'fecha_inicio' => '2024-01-15 00:00:00',
                'fecha_fin' => '2024-03-15 23:59:59',
                'dias_aplicables' => json_encode(['lunes', 'martes', 'miércoles', 'jueves', 'viernes']),
                'activa' => true,
            ],
            [
                'nombre' => 'Combo Familiar Dulce Hogar',
                'descripcion' => '4 helados medianos + 1 topping extra por familia. ¡Perfecto para compartir!',
                'tipo' => 'combo',
                'descuento_porcentaje' => 25.00,
                'fecha_inicio' => '2024-01-01 00:00:00',
                'fecha_fin' => '2024-12-31 23:59:59',
                'dias_aplicables' => json_encode(['sábado', 'domingo']),
                'activa' => true,
                'combo_detalle' => json_encode([
                    'items' => [
                        ['tipo' => 'producto', 'id' => 1, 'cantidad' => 2],
                        ['tipo' => 'producto', 'id' => 2, 'cantidad' => 2],
                        ['tipo' => 'ingrediente', 'id' => 1, 'cantidad' => 1],
                        ['tipo' => 'ingrediente', 'id' => 2, 'cantidad' => 1],
                    ],
                    'precio_combo' => 32.99,
                ]),
            ],
            [
                'nombre' => '¡Hoy es tu día más dulce!',
                'descripcion' => 'Helado gratis en tu cumpleaños. Porque los momentos especiales merecen sabores únicos.',
                'tipo' => 'cumpleaños',
                'descuento_porcentaje' => 100.00,
                'fecha_inicio' => '2024-01-01 00:00:00',
                'fecha_fin' => '2024-12-31 23:59:59',
                'dias_aplicables' => json_encode(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo']),
                'activa' => true,
            ],
        ];

        foreach ($promociones as $promocion) {
            Promocion::create($promocion);
        }
    }
}

