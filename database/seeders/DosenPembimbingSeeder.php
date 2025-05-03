<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenPembimbing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil dosen pertama sebagai pembimbing
        $dosen = Dosen::where('nip', '1234567890')->first();

        if ($dosen && !$dosen->pembimbing && !$dosen->penguji) {
            DosenPembimbing::create(attributes: [
                'dosen_id' => $dosen->id,
                'kapasitas_maksimum' => 5,
                'status_aktif' => true,
            ]);
        }
    }
}
