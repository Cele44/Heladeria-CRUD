<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductoIngredienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $relaciones = [
            // Helado de Vainilla
            ['producto_id' => 1, 'ingrediente_id' => 6, 'es_default' => true],
            ['producto_id' => 1, 'ingrediente_id' => 5, 'es_default' => true],
            ['producto_id' => 1, 'ingrediente_id' => 1, 'es_default' => false],
            ['producto_id' => 1, 'ingrediente_id' => 2, 'es_default' => false],
            ['producto_id' => 1, 'ingrediente_id' => 3, 'es_default' => false],
            
            // Helado de Chocolate
            ['producto_id' => 2, 'ingrediente_id' => 7, 'es_default' => true],
            ['producto_id' => 2, 'ingrediente_id' => 1, 'es_default' => true],
            ['producto_id' => 2, 'ingrediente_id' => 12, 'es_default' => false],
            ['producto_id' => 2, 'ingrediente_id' => 17, 'es_default' => false],
            
            // Sundae Especial
            ['producto_id' => 3, 'ingrediente_id' => 6, 'es_default' => true],
            ['producto_id' => 3, 'ingrediente_id' => 2, 'es_default' => true],
            ['producto_id' => 3, 'ingrediente_id' => 3, 'es_default' => true],
            ['producto_id' => 3, 'ingrediente_id' => 5, 'es_default' => true],
            
            // Milkshake de Fresa
            ['producto_id' => 4, 'ingrediente_id' => 8, 'es_default' => true],
            ['producto_id' => 4, 'ingrediente_id' => 3, 'es_default' => true],
            ['producto_id' => 4, 'ingrediente_id' => 5, 'es_default' => false],
            ['producto_id' => 4, 'ingrediente_id' => 7, 'es_default' => false],
        ];

        DB::table('producto_ingrediente')->insert($relaciones);
    }
}
