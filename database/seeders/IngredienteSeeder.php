<?php

namespace Database\Seeders;

use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class IngredienteSeeder extends Seeder
{
    public function run(): void
    {
        $ingredientes = [
            // Bases
            [
                'nombre' => 'Base de Vainilla',
                'descripcion' => 'Base cremosa de vainilla natural',
                'precio_extra' => 0.00,
                'tipo' => 'base',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/baseVanilla.jpg',
            ],
            [
                'nombre' => 'Base de Chocolate',
                'descripcion' => 'Base rica en chocolate belga',
                'precio_extra' => 0.00,
                'tipo' => 'base',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/baseChocolate.jpg',
            ],
            [
                'nombre' => 'Base de Fresa',
                'descripcion' => 'Base con fresas naturales',
                'precio_extra' => 0.00,
                'tipo' => 'base',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/baseFresa.jpg',
            ],
            [
                'nombre' => 'Base de Menta',
                'descripcion' => 'Base refrescante de menta',
                'precio_extra' => 0.20,
                'tipo' => 'base',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/baseMenta.jpg',
            ],

            // Toppings
            [
                'nombre' => 'Chispas de Chocolate',
                'descripcion' => 'Pequeñas chispas de chocolate negro',
                'precio_extra' => 0.50,
                'tipo' => 'topping',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/chispasChocolate.jpg',
            ],
            [
                'nombre' => 'Crema Batida',
                'descripcion' => 'Crema batida fresca',
                'precio_extra' => 0.60,
                'tipo' => 'topping',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/cremaBatida.jpg',
            ],
            [
                'nombre' => 'Granola',
                'descripcion' => 'Granola crujiente casera',
                'precio_extra' => 0.40,
                'tipo' => 'topping',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/granola.jpg',
            ],
            [
                'nombre' => 'Coco Rallado',
                'descripcion' => 'Coco fresco rallado',
                'precio_extra' => 0.30,
                'tipo' => 'topping',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/cocoRallado.jpg',
            ],

            // Salsas
            [
                'nombre' => 'Salsa de Caramelo',
                'descripcion' => 'Deliciosa salsa de caramelo casera',
                'precio_extra' => 0.75,
                'tipo' => 'salsa',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/salsaCaramelo.jpg',
            ],
            [
                'nombre' => 'Salsa de Chocolate',
                'descripcion' => 'Salsa de chocolate caliente',
                'precio_extra' => 0.50,
                'tipo' => 'salsa',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/salsaChocolate.jpg',
            ],
            [
                'nombre' => 'Salsa de Fresa',
                'descripcion' => 'Salsa natural de fresas',
                'precio_extra' => 0.60,
                'tipo' => 'salsa',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/salsaFresa.jpg',
            ],

            // Frutas
            [
                'nombre' => 'Fresas Frescas',
                'descripcion' => 'Fresas cortadas en trozos',
                'precio_extra' => 1.00,
                'tipo' => 'fruta',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/fresas.jpg',
            ],
            [
                'nombre' => 'Plátano',
                'descripcion' => 'Plátano maduro en rodajas',
                'precio_extra' => 0.80,
                'tipo' => 'fruta',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/platano.jpg',
            ],
            [
                'nombre' => 'Cerezas',
                'descripcion' => 'Cerezas dulces sin hueso',
                'precio_extra' => 1.20,
                'tipo' => 'fruta',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/cerezas.jpg',
            ],
            [
                'nombre' => 'Mango',
                'descripcion' => 'Mango tropical en cubos',
                'precio_extra' => 1.10,
                'tipo' => 'fruta',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/mango.jpg',
            ],

            // Nueces
            [
                'nombre' => 'Nueces Picadas',
                'descripcion' => 'Nueces tostadas y picadas',
                'precio_extra' => 0.80,
                'tipo' => 'nuez',
                'disponible' => false,
                'imagen_url' => '/storage/ingredientes/nuecesPicadas.jpg',
            ],
            [
                'nombre' => 'Almendras',
                'descripcion' => 'Almendras tostadas',
                'precio_extra' => 0.90,
                'tipo' => 'nuez',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/almendras.jpg',
            ],
            [
                'nombre' => 'Avellanas',
                'descripcion' => 'Avellanas tostadas',
                'precio_extra' => 1.00,
                'tipo' => 'nuez',
                'disponible' => true,
                'imagen_url' => '/storage/ingredientes/avellanas.jpg',
            ],
        ];

        foreach ($ingredientes as $ingrediente) {
            Ingrediente::create($ingrediente);
        }
    }
}

