<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $mahasiswa = [
            [
                'user_id' => 47, 
                'nim' => '20210001',
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'asal_kota' => $faker->city,
                'program_studi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'tahun_masuk' => 2021,
            ],
            [
                'user_id' => 48, 
                'nim' => '20210002',
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'asal_kota' => $faker->city,
                'program_studi' => 'Sistem Informasi',
                'fakultas' => 'Fakultas Teknik',
                'tahun_masuk' => 2021,
            ],
        ];

        Mahasiswa::insert($mahasiswa);
    }
}
