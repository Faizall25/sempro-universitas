<?php

namespace Database\Seeders;

use App\Models\PengajuanSempro;
use App\Models\Dosen;
use App\Models\DosenPembimbing;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PengajuanSemproSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil dosen pembimbing untuk bidang keilmuan ID 1 (Web & Mobile Programming)
        $dosenPembimbingBidang1 = Dosen::where('bidang_keilmuan_id', 1)
            ->whereIn('id', DosenPembimbing::pluck('dosen_id'))
            ->inRandomOrder()
            ->first();

        // Ambil dosen pembimbing untuk bidang keilmuan ID 5 (Intelligent System)
        $dosenPembimbingBidang5 = Dosen::where('bidang_keilmuan_id', 5)
            ->whereIn('id', DosenPembimbing::pluck('dosen_id'))
            ->inRandomOrder()
            ->first();

        // Validasi apakah dosen pembimbing tersedia
        if (!$dosenPembimbingBidang1 || !$dosenPembimbingBidang5) {
            throw new \Exception('Tidak ada dosen pembimbing untuk bidang keilmuan ID 1 atau 5. Pastikan DosenPembimbingSeeder telah menambahkan dosen yang sesuai.');
        }

        $pengajuan = [
            [
                'mahasiswa_id' => 1, // Mahasiswa 1
                'judul' => 'Sistem Penjadwalan Seminar Proposal Berbasis Web',
                'abstrak' => $faker->paragraph,
                'jurusan' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'bidang_keilmuan_id' => 1, // Web & Mobile Programming
                'dosen_pembimbing_id' => $dosenPembimbingBidang1->id,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2, // Mahasiswa 2
                'judul' => 'Prediksi Nilai Akademik dengan Machine Learning',
                'abstrak' => $faker->paragraph,
                'jurusan' => 'Sistem Informasi',
                'fakultas' => 'Fakultas Teknik',
                'bidang_keilmuan_id' => 5, // Intelligent System
                'dosen_pembimbing_id' => $dosenPembimbingBidang5->id,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        PengajuanSempro::insert($pengajuan);
    }
}
