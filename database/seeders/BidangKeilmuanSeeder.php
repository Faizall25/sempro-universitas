<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BidangKeilmuan;

class BidangKeilmuanSeeder extends Seeder
{
    public function run()
    {
        $bidangKeilmuan = [
            ['name' => 'Web & Mobile Programming'],
            ['name' => 'Multimedia & Teknologi Informasi'],
            ['name' => 'Information System'],
            ['name' => 'Software Engineering'],
            ['name' => 'Intelligent System'],
            ['name' => 'System & Network'],
        ];

        foreach ($bidangKeilmuan as $bidang) {
            BidangKeilmuan::create($bidang);
        }
    }
}