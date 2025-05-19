<?php

namespace Database\Seeders;

use App\Models\BidangKeilmuan;
use App\Models\Dosen;
use App\Models\DosenPenguji;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DosenPengujiSeeder extends Seeder
{
    public function run()
    {
        $bidangKeilmuanList = [
            'Web & Mobile Programming',
            'Multimedia & Teknologi Informasi',
            'Information System',
            'Software Engineering',
            'Intelligent System',
            'System & Network',
        ];

        foreach ($bidangKeilmuanList as $bidangName) {
            $bidang = BidangKeilmuan::where('name', $bidangName)->first();

            if (!$bidang) {
                continue;
            }

            // Take 4 dosen per bidang (increased from 3)
            $dosenList = Dosen::where('bidang_keilmuan_id', $bidang->id)
                ->inRandomOrder()
                ->take(4)
                ->get();

            if ($dosenList->count() < 4) {
                Log::warning("Hanya {$dosenList->count()} dosen ditemukan untuk bidang keilmuan {$bidangName}. Dibutuhkan minimal 4 dosen.");
                continue;
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
