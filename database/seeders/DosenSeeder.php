<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $dosen = [
            [
                'user_id' => 2, // Dr. Budi Santoso
                'nip' => '1234567890',
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '1980-01-01'),
                'asal_kota' => $faker->city,
                'bidang_keilmuan_id' => 1, // Sistem Informasi
                'peran' => 'pembimbing',
            ],
            [
                'user_id' => 3, // Prof. Anita Wijaya
                'nip' => '0987654321',
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '1975-01-01'),
                'asal_kota' => $faker->city,
                'bidang_keilmuan_id' => 2, // Kecerdasan Buatan
                'peran' => 'penguji',
            ],
        ];

        Dosen::insert($dosen);
    }
}
