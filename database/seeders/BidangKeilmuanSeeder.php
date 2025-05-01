<?php

namespace Database\Seeders;

use App\Models\BidangKeilmuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangKeilmuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidang = [
            ['name' => 'Sistem Informasi'],
            ['name' => 'Kecerdasan Buatan'],
            ['name' => 'Jaringan Komputer'],
            ['name' => 'Neuro Linguistic Program'],
            ['name' => 'Rekayasa Perangkat Lunak'],
        ];

        BidangKeilmuan::insert($bidang);
    }
}
