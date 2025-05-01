<?php

namespace Database\Seeders;

use App\Models\HasilSempro;
use Illuminate\Database\Seeder;

class HasilSemproSeeder extends Seeder
{
    public function run(): void
    {
        $hasil = [
            [
                'jadwal_sempro_id' => 1, // Jadwal Rina Amelia
                'nilai_peng1' => 85.5,
                'nilai_peng2' => 88.0,
                'nilai_peng3' => 90.0,
                'rata_rata' => (85.5 + 88.0 + 90.0) / 3,
                'status' => 'lolos_tanpa_revisi',
                'revisi_file_path' => null,
            ],
            [
                'jadwal_sempro_id' => 2, // Jadwal Ahmad Fauzi
                'nilai_peng1' => 75.0,
                'nilai_peng2' => 70.0,
                'nilai_peng3' => 72.5,
                'rata_rata' => (75.0 + 70.0 + 72.5) / 3,
                'status' => 'revisi_minor',
                'revisi_file_path' => 'revisi/ahmad_fauzi_revisi.pdf',
            ],
        ];

        HasilSempro::insert($hasil);
    }
}
