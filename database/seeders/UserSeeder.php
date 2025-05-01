<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Fakultas',
                'email' => 'admin@universitas.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi.santoso@universitas.com',
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Prof. Anita Wijaya',
                'email' => 'anita.wijaya@universitas.com',
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ],
            [
                'name' => 'Rina Amelia',
                'email' => 'rina.amelia@student.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@student.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ],
        ];

        User::insert($users);
    }
}
