<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de usuarios.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'nbrian.avila96@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('sigead123456@'),
        ]);
    }
}
