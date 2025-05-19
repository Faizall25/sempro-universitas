<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $mahasiswa = [];

        for ($i = 0; $i < 12; $i++) {
            $mahasiswa[] = [
                'user_id' => 47 + $i, // 47 to 58
                'nim' => '202100' . str_pad($i + 1, 2, '0', STR_PAD_LEFT), // 20210001 to 20210012
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'asal_kota' => $faker->city,
                'program_studi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'tahun_masuk' => 2021,
            ];
        }

        Mahasiswa::insert($mahasiswa);
    }
}
