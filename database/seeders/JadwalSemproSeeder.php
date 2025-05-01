<?php

namespace Database\Seeders;

use App\Models\JadwalSempro;
use Illuminate\Database\Seeder;

class JadwalSemproSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            [
                'pengajuan_sempro_id' => 1, // Pengajuan Rina Amelia
                'tanggal' => '2025-06-01',
                'waktu' => '12:00:00',
                'ruang' => 'Ruang Seminar 1',
                'dosen_penguji_1' => 2, // Prof. Anita Wijaya
                'dosen_penguji_2' => 1, // Dr. Budi Santoso
                'dosen_penguji_3' => 1, // Dr. Budi Santoso (cadangan)
                'status' => 'dijadwalkan',
            ],
            [
                'pengajuan_sempro_id' => 2, // Pengajuan Ahmad Fauzi
                'tanggal' => '2025-06-02',
                'waktu' => '14:00:00',
                'ruang' => 'Ruang Seminar 2',
                'dosen_penguji_1' => 1, // Dr. Budi Santoso
                'dosen_penguji_2' => 2, // Prof. Anita Wijaya
                'dosen_penguji_3' => 2, // Prof. Anita Wijaya (cadangan)
                'status' => 'dijadwalkan',
            ],
        ];

        JadwalSempro::insert($jadwal);
    }
}
