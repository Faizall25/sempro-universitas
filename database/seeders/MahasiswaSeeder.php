<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $mahasiswa = [
            [
                'user_id' => 4, // Rina Amelia
                'nim' => '20210001',
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'asal_kota' => $faker->city,
                'program_studi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'tahun_masuk' => 2021,
            ],
            [
                'user_id' => 5, // Ahmad Fauzi
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
