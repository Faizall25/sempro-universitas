<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\BidangKeilmuan;
use App\Models\DosenPenguji;
use App\Models\DosenPembimbing;

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

            // Ambil dosen yang bukan pembimbing untuk bidang keilmuan ini
            $pembimbingIds = DosenPembimbing::whereIn('dosen_id', Dosen::where('bidang_keilmuan_id', $bidang->id)->pluck('id'))
                ->pluck('dosen_id')
                ->toArray();

            // Ambil 3 dosen dengan bidang keilmuan yang sesuai, bukan pembimbing
            $dosenList = Dosen::where('bidang_keilmuan_id', $bidang->id)
                ->whereNotIn('id', $pembimbingIds)
                ->inRandomOrder()
                ->take(3)
                ->get();

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
