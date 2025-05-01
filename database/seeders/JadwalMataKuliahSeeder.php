<?php

namespace Database\Seeders;

use App\Models\JadwalMataKuliah;
use Illuminate\Database\Seeder;

class JadwalMataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            [
                'hari' => 'Senin',
                'pukul' => '08:00:00',
                'kelas' => 'TI-4A',
                'ruang' => 'Lab Komputer 1',
                'kode' => 'TI101',
                'mata_kuliah' => 'Pemrograman Web',
                'sks' => 3,
                'dosen_id' => 1, // Dr. Budi Santoso
                'asisten_dosen' => 'Asisten 1',
                'mk_jurusan' => 'Teknik Informatika',
                'keterangan' => 'Praktikum minggu 1-16',
            ],
            [
                'hari' => 'Selasa',
                'pukul' => '10:00:00',
                'kelas' => 'SI-4B',
                'ruang' => 'Ruang 202',
                'kode' => 'SI202',
                'mata_kuliah' => 'Kecerdasan Buatan',
                'sks' => 3,
                'dosen_id' => 2, // Prof. Anita Wijaya
                'asisten_dosen' => null,
                'mk_jurusan' => 'Sistem Informasi',
                'keterangan' => null,
            ],
        ];

        JadwalMataKuliah::insert($jadwal);
    }
}
