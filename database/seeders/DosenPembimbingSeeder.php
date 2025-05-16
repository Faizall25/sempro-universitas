<?php

namespace Database\Seeders;

use App\Models\DosenPembimbing;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\BidangKeilmuan;

class DosenPembimbingSeeder extends Seeder
{
    public function run()
    {
        // Daftar bidang keilmuan
        $bidangKeilmuanList = [
            'Web & Mobile Programming',
            'Multimedia & Teknologi Informasi',
            'Information System',
            'Software Engineering',
            'Intelligent System',
            'System & Network',
        ];

        foreach ($bidangKeilmuanList as $bidangName) {
            // Ambil bidang keilmuan
            $bidang = BidangKeilmuan::where('name', $bidangName)->first();

            if (!$bidang) {
                continue; // Lewati jika bidang keilmuan tidak ditemukan
            }

            // Ambil 3 dosen dengan bidang keilmuan yang sesuai
            $dosenList = Dosen::where('bidang_keilmuan_id', $bidang->id)
                ->inRandomOrder()
                ->take(3)
                ->get();

            foreach ($dosenList as $dosen) {
                DosenPembimbing::create([
                    'dosen_id' => $dosen->id,
                    'kapasitas_maksimum' => 5,
                    'status_aktif' => true,
                ]);
            }
        }
    }
}