<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promocion>
 */
class PromocionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Creamos items aleatorios para el combo (productos e ingredientes)
        $items = [
            [
                'tipo' => 'producto',
                'id' => $this->faker->numberBetween(1, 20), // IDs de productos simulados
                'cantidad' => $this->faker->numberBetween(1, 5),
            ],
            [
                'tipo' => 'ingrediente',
                'id' => $this->faker->numberBetween(1, 10), // IDs de ingredientes simulados
                'cantidad' => $this->faker->numberBetween(1, 3),
            ],
        ];

        return [
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->paragraph(),
            'tipo' => fake()->randomElement(['2x1', 'combo', 'happy_hour', 'primera_compra', 'cumpleaños']),
            'descuento_porcentaje' => fake()->randomFloat(2, 5, 30),
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonths(2),
            'dias_aplicables' => json_encode(fake()->randomElements(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'], fake()->numberBetween(1, 7))),
            'activa' => true,
            'combo_detalle' => json_encode([
                'items' => $items,
                'precio_combo' => $this->faker->randomFloat(2, 20, 50),
            ]),
        ];
    }
}
