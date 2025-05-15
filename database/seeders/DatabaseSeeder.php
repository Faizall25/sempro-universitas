<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BidangKeilmuanSeeder::class,
            UserSeeder::class,
            DosenSeeder::class,
            DosenPembimbingSeeder::class,
            DosenPengujiSeeder::class,
            MahasiswaSeeder::class,
            PengajuanSemproSeeder::class,
            JadwalMataKuliahSeeder::class,
            JadwalSemproSeeder::class,
            HasilSemproSeeder::class,
        ]);
    }
}
