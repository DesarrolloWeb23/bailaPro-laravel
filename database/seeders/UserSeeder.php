<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrNew([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Administrador',
            'password' => bcrypt('admin123'),
            'date_of_birth' => '1990-01-01',
            'phone' => '1234567890',
            'state_id' => 1,
        ]);

        // Si el usuario no existe, se guardará.
        if (!$user->exists) {
            $user->save();
        }

        // Asignar el rol al usuario
        $user->assignRole('Administrador');
    }
}
