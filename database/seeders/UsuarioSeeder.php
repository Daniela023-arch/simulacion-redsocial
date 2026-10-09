<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'nombre' => 'Daniela López',
                'username' => 'daniela',
                'email' => 'daniela@pensarium.com',
            ],
            [
                'nombre' => 'Mariana García',
                'username' => 'mariana',
                'email' => 'mariana@pensarium.com',
            ],
            [
                'nombre' => 'Carlos Hernández',
                'username' => 'carlos',
                'email' => 'carlos@pensarium.com',
            ],
            [
                'nombre' => 'Sofía Ramírez',
                'username' => 'sofia',
                'email' => 'sofia@pensarium.com',
            ],
            [
                'nombre' => 'Alejandro Torres',
                'username' => 'alejandro',
                'email' => 'alejandro@pensarium.com',
            ],
            [
                'nombre' => 'Valeria Mendoza',
                'username' => 'valeria',
                'email' => 'valeria@pensarium.com',
            ],
            [
                'nombre' => 'Diego Morales',
                'username' => 'diego',
                'email' => 'diego@pensarium.com',
            ],
            [
                'nombre' => 'Camila Flores',
                'username' => 'camila',
                'email' => 'camila@pensarium.com',
            ],
            [
                'nombre' => 'Sebastián Ruiz',
                'username' => 'sebastian',
                'email' => 'sebastian@pensarium.com',
            ],
            [
                'nombre' => 'Lucía Fernández',
                'username' => 'lucia',
                'email' => 'lucia@pensarium.com',
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create([
                'nombre' => $usuario['nombre'],
                'username' => $usuario['username'],
                'email' => $usuario['email'],
                'password' => Hash::make('Password123!'),
            ]);
        }
    }
}
