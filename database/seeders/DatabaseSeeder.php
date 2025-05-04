<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

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
