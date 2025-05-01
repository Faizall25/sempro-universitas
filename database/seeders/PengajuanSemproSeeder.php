<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PengajuanSempro;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PengajuanSemproSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $pengajuan = [
            [
                'mahasiswa_id' => 1, // Rina Amelia
                'judul' => 'Sistem Penjadwalan Seminar Proposal Berbasis Web',
                'abstrak' => $faker->paragraph,
                'jurusan' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'bidang_keilmuan_id' => 1, // Sistem Informasi
                'dosen_pembimbing_id' => 1, // Dr. Budi Santoso
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2, // Ahmad Fauzi
                'judul' => 'Prediksi Nilai Akademik dengan Machine Learning',
                'abstrak' => $faker->paragraph,
                'jurusan' => 'Sistem Informasi',
                'fakultas' => 'Fakultas Teknik',
                'bidang_keilmuan_id' => 2, // Kecerdasan Buatan
                'dosen_pembimbing_id' => 2, // Prof. Anita Wijaya
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        PengajuanSempro::insert($pengajuan);
    }
}
