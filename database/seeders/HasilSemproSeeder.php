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
                'jadwal_sempro_id' => 1,
                'nilai_peng1' => 88.5,
                'nilai_peng2' => 90.0,
                'nilai_peng3' => 87.5,
                'rata_rata' => (88.5 + 90.0 + 87.5) / 3,
                'status' => 'lolos_tanpa_revisi',
                'revisi_file_path' => null,
            ],
            [
                'jadwal_sempro_id' => 2,
                'nilai_peng1' => 78.0,
                'nilai_peng2' => 75.5,
                'nilai_peng3' => 77.0,
                'rata_rata' => (78.0 + 75.5 + 77.0) / 3,
                'status' => 'revisi_minor',
                'revisi_file_path' => 'revisi/pengajuan_2_revisi.pdf',
            ],
            [
                'jadwal_sempro_id' => 3,
                'nilai_peng1' => 70.0,
                'nilai_peng2' => 68.5,
                'nilai_peng3' => 71.5,
                'rata_rata' => (70.0 + 68.5 + 71.5) / 3,
                'status' => 'revisi_mayor',
                'revisi_file_path' => 'revisi/pengajuan_3_revisi.pdf',
            ],
            [
                'jadwal_sempro_id' => 4,
                'nilai_peng1' => 60.0,
                'nilai_peng2' => 62.5,
                'nilai_peng3' => 61.0,
                'rata_rata' => (60.0 + 62.5 + 61.0) / 3,
                'status' => 'tidak_lolos',
                'revisi_file_path' => null,
            ],
        ];

        HasilSempro::insert($hasil);
    }
}
