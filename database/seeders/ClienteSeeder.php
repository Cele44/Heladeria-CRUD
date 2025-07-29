<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'email' => 'maria@email.com',
                'telefono' => '+1234567890',
                'direccion' => 'Calle 123, Ciudad',
                'password_hash' => Hash::make('password123'),
                'activo' => true,
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan@email.com',
                'telefono' => '+1234567891',
                'direccion' => 'Avenida 456, Ciudad',
                'password_hash' => Hash::make('password123'),
                'activo' => true,
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'López',
                'email' => 'ana@email.com',
                'telefono' => '+1234567892',
                'direccion' => 'Plaza 789, Ciudad',
                'password_hash' => Hash::make('password123'),
                'activo' => false,
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Ruiz',
                'email' => 'carlos@email.com',
                'telefono' => '+1234567893',
                'direccion' => 'Boulevard 321, Ciudad',
                'password_hash' => Hash::make('password123'),
                'activo' => true,
            ],
            [
                'nombre' => 'Sofia',
                'apellido' => 'Martinez',
                'email' => 'sofia@email.com',
                'telefono' => '+1234567894',
                'direccion' => 'Calle Nueva 456, Ciudad',
                'password_hash' => Hash::make('password123'),
                'activo' => true,
            ],
            [
                'nombre' => 'Sofia',
                'apellido' => 'Martinez',
                'email' => 'admin@email.com',
                'telefono' => '+1234567894',
                'direccion' => 'Calle Nueva 456, Ciudad',
                'password_hash' => Hash::make('password123'),
                'activo' => true,
                'rol' => true, // Asignar rol de administrador
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }

        // Crear clientes adicionales con factory eso si quieres ferchis 
        // Cliente::factory(10)->create();
    }
}