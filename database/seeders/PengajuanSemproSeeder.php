<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenPembimbing;
use App\Models\Mahasiswa;
use App\Models\PengajuanSempro;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PengajuanSemproSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Daftar judul berdasarkan bidang keilmuan (increased variety)
        $judulByBidang = [
            1 => [ // Web & Mobile Programming
                'Aplikasi E-Commerce Berbasis Web dengan Laravel dan Vue.js',
                'Sistem Manajemen Konten Mobile untuk UMKM Berbasis Flutter',
                'Aplikasi Pemesanan Tiket Online dengan React Native',
                'Platform Pembelajaran Online Berbasis Web Progressive',
                'Aplikasi Chatting Real-Time dengan WebSocket',
            ],
            2 => [ // Multimedia & Teknologi Informasi
                'Aplikasi Augmented Reality untuk Pendidikan Interaktif',
                'Sistem Visualisasi Data 3D Berbasis WebGL',
                'Aplikasi Editing Video Berbasis AI dengan OpenCV',
                'Platform Animasi Interaktif untuk Storytelling Digital',
                'Sistem Pengenalan Suara untuk Aplikasi Multimedia',
            ],
            3 => [ // Information System
                'Sistem Informasi Manajemen Rumah Sakit Berbasis Cloud',
                'Aplikasi Inventori Gudang dengan Integrasi IoT',
                'Sistem Informasi Akademik Universitas dengan API',
                'Platform Manajemen Proyek Berbasis ERP',
                'Sistem Informasi Keuangan untuk Organisasi Nirlaba',
            ],
            4 => [ // Software Engineering
                'Otomatisasi Pengujian Perangkat Lunak dengan Selenium dan Jenkins',
                'Implementasi DevOps untuk Pengembangan Aplikasi Skala Besar',
                'Framework Pengembangan Aplikasi Berbasis Microservices',
                'Sistem Verifikasi Kualitas Kode dengan Static Analysis',
                'Pipeline CI/CD untuk Aplikasi Berbasis Kontainer',
            ],
            5 => [ // Intelligent System
                'Prediksi Penyakit Jantung dengan Model Deep Learning',
                'Sistem Rekomendasi Produk Menggunakan Collaborative Filtering',
                'Deteksi Objek pada Video dengan YOLOv5',
                'Sistem Klasifikasi Teks Berbasis BERT',
                'Prediksi Cuaca dengan Machine Learning',
            ],
            6 => [ // System & Network
                'Sistem Keamanan Jaringan Berbasis Firewall dan IDS',
                'Optimasi Jaringan IoT untuk Smart City dengan MQTT',
                'Sistem Monitoring Jaringan Berbasis Software-Defined Networking',
                'Implementasi VPN untuk Keamanan Data Perusahaan',
                'Sistem Load Balancing untuk Server Berbasis Cloud',
            ],
        ];

        $pengajuan = [];
        // Define 12 proposals: 10 diterima (for JadwalSempro), 1 pending, 1 ditolak
        $configs = [
            ['mahasiswa_id' => 1, 'bidang_id' => 1, 'status' => 'diterima'], // Web & Mobile
            ['mahasiswa_id' => 2, 'bidang_id' => 1, 'status' => 'diterima'], // Web & Mobile
            ['mahasiswa_id' => 3, 'bidang_id' => 2, 'status' => 'diterima'], // Multimedia
            ['mahasiswa_id' => 4, 'bidang_id' => 2, 'status' => 'diterima'], // Multimedia
            ['mahasiswa_id' => 5, 'bidang_id' => 3, 'status' => 'diterima'], // Information System
            ['mahasiswa_id' => 6, 'bidang_id' => 3, 'status' => 'diterima'], // Information System
            ['mahasiswa_id' => 7, 'bidang_id' => 4, 'status' => 'diterima'], // Software Engineering
            ['mahasiswa_id' => 8, 'bidang_id' => 4, 'status' => 'diterima'], // Software Engineering
            ['mahasiswa_id' => 9, 'bidang_id' => 5, 'status' => 'diterima'], // Intelligent System
            ['mahasiswa_id' => 10, 'bidang_id' => 6, 'status' => 'diterima'], // System & Network
            ['mahasiswa_id' => 1, 'bidang_id' => 1, 'status' => 'ditolak'], // Same student, rejected earlier
            ['mahasiswa_id' => 11, 'bidang_id' => 5, 'status' => 'pending'], // New student, pending
        ];

        foreach ($configs as $index => $config) {
            $mahasiswa = Mahasiswa::find($config['mahasiswa_id']);
            if (!$mahasiswa) {
                throw new \Exception("Mahasiswa ID {$config['mahasiswa_id']} tidak ditemukan. Pastikan MahasiswaSeeder telah dijalankan.");
            }

            $bidangId = $config['bidang_id'];
            $dosenPembimbing = Dosen::where('bidang_keilmuan_id', $bidangId)
                ->whereIn('id', DosenPembimbing::pluck('dosen_id'))
                ->inRandomOrder()
                ->first();

            if (!$dosenPembimbing) {
                throw new \Exception("Tidak ada dosen pembimbing untuk bidang keilmuan ID {$bidangId}. Pastikan DosenPembimbingSeeder telah menambahkan dosen yang sesuai.");
            }

            $pengajuan[] = [
                'mahasiswa_id' => $config['mahasiswa_id'],
                'judul' => $judulByBidang[$bidangId][array_rand($judulByBidang[$bidangId])],
                'abstrak' => $faker->paragraph(3),
                'jurusan' => $mahasiswa->program_studi,
                'fakultas' => $mahasiswa->fakultas,
                'bidang_keilmuan_id' => $bidangId,
                'dosen_pembimbing_id' => $dosenPembimbing->id,
                'status' => $config['status'],
                'created_at' => now()->subDays($config['status'] === 'ditolak' ? rand(60, 90) : ($config['status'] === 'pending' ? rand(1, 10) : rand(20, 50))),
                'updated_at' => now(),
            ];
        }

        PengajuanSempro::insert($pengajuan);
    }
}
