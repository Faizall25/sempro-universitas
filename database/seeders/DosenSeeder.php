<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\User;
use App\Models\BidangKeilmuan;

class DosenSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada data di tabel bidang_keilmuan
        $bidangKeilmuan = BidangKeilmuan::firstOrCreate(['name' => 'Ilmu Komputer']);

        // Buat user dosen jika belum ada
        $user1 = User::firstOrCreate([
            'email' => 'dosen1@university.com',
            'role' => 'dosen',
        ], [
            'name' => 'Dosen Satu',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::firstOrCreate([
            'email' => 'dosen2@university.com',
            'role' => 'dosen',
        ], [
            'name' => 'Dosen Dua',
            'password' => bcrypt('password'),
        ]);

        // Tambah data ke tabel dosen
        Dosen::create([
            'user_id' => $user1->id,
            'nip' => '1234567890',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'asal_kota' => 'Jakarta',
            'bidang_keilmuan_id' => $bidangKeilmuan->id,
        ]);

        Dosen::create([
            'user_id' => $user2->id,
            'nip' => '0987654321',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1982-03-15',
            'asal_kota' => 'Surabaya',
            'bidang_keilmuan_id' => $bidangKeilmuan->id,
        ]);
    }
}
