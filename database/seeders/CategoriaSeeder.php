<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Helados Clásicos',
                'descripcion' => 'Los sabores tradicionales que siempre gustan',
                'imagen_url' => '/storage/categorias/heladosClasicos.jpg',
                'orden_display' => 1,
                'activa' => true,
            ],
            [
                'nombre' => 'Sundaes',
                'descripcion' => 'Deliciosos sundaes con toppings especiales',
                'imagen_url' => '/storage/categorias/sundaes.jpg',
                'orden_display' => 2,
                'activa' => true,
            ],
            [
                'nombre' => 'Milkshakes',
                'descripcion' => 'Batidos cremosos y refrescantes',
                'imagen_url' => '/storage/categorias/milkshakes.jpg',
                'orden_display' => 3,
                'activa' => true,
            ],
            [
                'nombre' => 'Postres Especiales',
                'descripcion' => 'Creaciones únicas de la casa',
                'imagen_url' => '/storage/categorias/postresEspeciales.jpg',
                'orden_display' => 4,
                'activa' => true,
            ],
            [
                'nombre' => 'Helados Premium',
                'descripcion' => 'Sabores gourmet con ingredientes selectos',
                'imagen_url' => '/storage/categorias/heladosPremium.jpg',
                'orden_display' => 5,
                'activa' => true,
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}