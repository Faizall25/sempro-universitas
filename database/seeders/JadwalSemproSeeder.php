<?php

namespace Database\Seeders;

use App\Models\JadwalSempro;
use App\Models\JadwalSemproApproval;
use App\Models\Dosen;
use App\Models\DosenPenguji;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSemproSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil dosen penguji untuk bidang keilmuan ID 1 (Web & Mobile Programming)
        $dosenBidang1 = Dosen::where('bidang_keilmuan_id', 1)
            ->whereIn('id', DosenPenguji::pluck('dosen_id'))
            ->inRandomOrder()
            ->take(3)
            ->pluck('id')
            ->toArray();

        // Ambil dosen penguji untuk bidang keilmuan ID 5 (Intelligent System)
        $dosenBidang5 = Dosen::where('bidang_keilmuan_id', 5)
            ->whereIn('id', DosenPenguji::pluck('dosen_id'))
            ->inRandomOrder()
            ->take(3)
            ->pluck('id')
            ->toArray();

        // Pastikan ada cukup dosen untuk masing-masing bidang
        if (count($dosenBidang1) < 3 || count($dosenBidang5) < 3) {
            throw new \Exception('Tidak cukup dosen penguji untuk bidang keilmuan ID 1 atau 5. Pastikan DosenPengujiSeeder telah menambahkan dosen yang sesuai.');
        }

        $jadwal = [
            [
                'pengajuan_sempro_id' => 1, // Pengajuan Mahasiswa 1
                'tanggal' => '2025-06-01',
                'waktu' => '12:00:00',
                'ruang' => 'Ruang Seminar 1',
                'dosen_penguji_1' => $dosenBidang1[0],
                'dosen_penguji_2' => $dosenBidang1[1],
                'dosen_penguji_3' => $dosenBidang1[2],
                'status' => 'dijadwalkan',
            ],
            [
                'pengajuan_sempro_id' => 2, // Pengajuan Mahasiswa 2
                'tanggal' => '2025-06-02',
                'waktu' => '14:00:00',
                'ruang' => 'Ruang Seminar 2',
                'dosen_penguji_1' => $dosenBidang5[0],
                'dosen_penguji_2' => $dosenBidang5[1],
                'dosen_penguji_3' => $dosenBidang5[2],
                'status' => 'dijadwalkan',
            ],
        ];

        foreach ($jadwal as $data) {
            DB::transaction(function () use ($data) {
                // Create JadwalSempro
                $jadwalSempro = JadwalSempro::create($data);

                // Create JadwalSemproApproval for each dosen penguji
                $approvals = [
                    [
                        'jadwal_sempro_id' => $jadwalSempro->id,
                        'dosen_id' => $data['dosen_penguji_1'],
                        'status' => 'pending',
                        'approved_at' => null,
                    ],
                    [
                        'jadwal_sempro_id' => $jadwalSempro->id,
                        'dosen_id' => $data['dosen_penguji_2'],
                        'status' => 'pending',
                        'approved_at' => null,
                    ],
                    [
                        'jadwal_sempro_id' => $jadwalSempro->id,
                        'dosen_id' => $data['dosen_penguji_3'],
                        'status' => 'pending',
                        'approved_at' => null,
                    ],
                ];

                JadwalSemproApproval::insert($approvals);
            });
        }
    }
}
