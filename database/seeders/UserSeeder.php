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
        $admin = User::firstOrCreate(
            ['email' => 'nbrian.avila96@gmail.com'],
            [
                'name' => 'Administrador',
                'email_verified_at' => now(),
                'password' => Hash::make('sigead123456@'),
            ]
        );
        $admin->assignRole('admin');

        // Crear usuario manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@ecommerce.com'],
            [
                'name' => 'Manager',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
            ]
        );
        $manager->assignRole('manager');

        // Crear usuario vendedor
        $vendedor = User::firstOrCreate(
            ['email' => 'vendedor@ecommerce.com'],
            [
                'name' => 'Vendedor',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
            ]
        );
        $vendedor->assignRole('vendedor');

        // Crear usuario cliente
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@ecommerce.com'],
            [
                'name' => 'Cliente',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
            ]
        );
        $cliente->assignRole('cliente');
    }
}
