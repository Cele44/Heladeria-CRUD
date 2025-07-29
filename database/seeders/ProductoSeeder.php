<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $categoriaClasicos = Categoria::where('nombre', 'Helados Clásicos')->first();
        $categoriaSundaes = Categoria::where('nombre', 'Sundaes')->first();
        $categoriaMilkshakes = Categoria::where('nombre', 'Milkshakes')->first();

        $productos = [
            [
                'nombre' => 'Helado de Vainilla',
                'descripcion' => 'Cremoso helado de vainilla natural',
                'categoria_id' => $categoriaClasicos->id,
                'precio_base' => 5.99,
                'disponible' => true,
                'es_personalizado' => true,
                'tiempo_preparacion' => 5,
                'ingredientes_default' => [6, 5], // Base de Vainilla, Crema Batida
                'ingredientes_personalizables' => [1, 2, 3], // Chispas, Caramelo, Fresas
                'imagen_url' => '/storage/productos/heladoVainilla.jpg',
            ],
            [
                'nombre' => 'Helado de Chocolate',
                'descripcion' => 'Rico helado de chocolate belga',
                'categoria_id' => $categoriaClasicos->id,
                'precio_base' => 6.99,
                'disponible' => true,
                'es_personalizado' => true,
                'tiempo_preparacion' => 5,
                'ingredientes_default' => [7, 1], // Base de Chocolate, Chispas
                'ingredientes_personalizables' => [12, 17], // Salsa Chocolate, Almendras
                'imagen_url' => '/storage/productos/heladoChocolate.jpg',
            ],
            [
                'nombre' => 'Sundae Especial',
                'descripcion' => 'Sundae con frutas y salsa de caramelo',
                'categoria_id' => $categoriaSundaes->id,
                'precio_base' => 8.99,
                'disponible' => true,
                'es_personalizado' => false,
                'tiempo_preparacion' => 10,
                'ingredientes_default' => [6, 2, 3, 5], // Vainilla, Caramelo, Fresas, Crema
                'imagen_url' => '/storage/productos/sundaeEspecial.jpg',
            ],
            [
                'nombre' => 'Milkshake de Fresa',
                'descripcion' => 'Batido cremoso de fresa natural',
                'categoria_id' => $categoriaMilkshakes->id,
                'precio_base' => 7.50,
                'disponible' => true,
                'es_personalizado' => true,
                'tiempo_preparacion' => 8,
                'ingredientes_default' => [8, 3], // Base Fresa, Fresas
                'ingredientes_personalizables' => [5, 7], // Crema, Granola
                'imagen_url' => '/storage/productos/milkshakeFresa.jpg',
            ],
        ];

        foreach ($productos as $productoData) {
            $ingredientesDefault = $productoData['ingredientes_default'] ?? [];
            $ingredientesPersonalizables = $productoData['ingredientes_personalizables'] ?? [];

            unset($productoData['ingredientes_default'], $productoData['ingredientes_personalizables']);

            $producto = Producto::create($productoData);

            // Asociar ingredientes por defecto
            foreach ($ingredientesDefault as $ingredienteId) {
                $producto->ingredientes()->attach($ingredienteId, ['es_default' => true]);
            }

            // Asociar ingredientes personalizables
            foreach ($ingredientesPersonalizables as $ingredienteId) {
                $producto->ingredientes()->attach($ingredienteId, ['es_default' => false]);
            }
        }

    }
}
