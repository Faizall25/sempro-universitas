<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\BidangKeilmuan;
use App\Models\DosenPenguji;
use Illuminate\Support\Facades\Log;

class DosenPengujiSeeder extends Seeder
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

            // Ambil 3 dosen dengan bidang keilmuan yang sesuai (termasuk yang sudah pembimbing)
            $dosenList = Dosen::where('bidang_keilmuan_id', $bidang->id)
                ->inRandomOrder()
                ->take(3)
                ->get();

            if ($dosenList->count() < 3) {
                Log::warning("Hanya {$dosenList->count()} dosen ditemukan untuk bidang keilmuan {$bidangName}. Dibutuhkan minimal 3 dosen.");
                continue; // Lewati jika tidak cukup dosen
            }

            foreach ($dosenList as $dosen) {
                DosenPenguji::create([
                    'dosen_id' => $dosen->id,
                    'pengalaman_jadi_penguji' => 3,
                    'status_aktif' => true,
                ]);
            }
        }
    }
}
