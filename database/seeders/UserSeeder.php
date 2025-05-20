<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'birth_date' => '1990-01-01',
            'role' => 'admin',
        ]);

        // Usuaris normals
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Usuari ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'birth_date' => now()->subYears(rand(16, 30))->format('Y-m-d'),
                'role' => 'user',
            ]);
        }
    }
}
