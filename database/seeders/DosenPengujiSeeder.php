<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenPenguji;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenPengujiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil dosen kedua sebagai penguji
        $dosen = Dosen::where('nip', '0987654321')->first();

        if ($dosen && !$dosen->pembimbing && !$dosen->penguji) {
            DosenPenguji::create([
                'dosen_id' => $dosen->id,
                'pengalaman_jadi_penguji' => 3,
                'status_aktif' => true,
            ]);
        }
    }
}
