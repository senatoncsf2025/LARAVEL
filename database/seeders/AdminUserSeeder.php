<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar ADMINISTRADOR
        User::updateOrCreate(
            ['email' => 'elkingustavo15@gmail.com'], // busca por email
            [
                'name' => 'Administrador',
                'password' => Hash::make('Elkin.20061'),
                'rol' => 1, // Rol de administrador
                'telefono' => '0000000000',
                'cedula' => '1234567890',
            ]
        );

        // Crear o actualizar VIGILANTE
        User::updateOrCreate(
            ['email' => 'vigilante@siorti.com'], // busca por email
            [
                'name' => 'Vigilante General',
                'password' => Hash::make('vigilante123'),
                'rol' => 2, // Rol de vigilante
                'telefono' => '1111111111',
                'cedula' => '9876543210',
            ]
        );
    }
}
