<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenPenguji;
use App\Models\JadwalSempro;
use App\Models\JadwalSemproApproval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSemproSeeder extends Seeder
{
    public function run(): void
    {
        // Define schedule details: dates, times, and rooms
        $scheduleDetails = [
            ['tanggal' => '2025-06-01', 'waktu' => '12:00:00', 'ruang' => 'Ruang Seminar 1'],
            ['tanggal' => '2025-06-01', 'waktu' => '13:00:00', 'ruang' => 'Ruang Seminar 2'],
            ['tanggal' => '2025-06-02', 'waktu' => '12:00:00', 'ruang' => 'Ruang Seminar 3'],
            ['tanggal' => '2025-06-02', 'waktu' => '13:00:00', 'ruang' => 'Ruang Seminar 1'],
            ['tanggal' => '2025-06-03', 'waktu' => '14:00:00', 'ruang' => 'Ruang Seminar 2'],
            ['tanggal' => '2025-06-03', 'waktu' => '13:00:00', 'ruang' => 'Ruang Seminar 3'],
            ['tanggal' => '2025-06-04', 'waktu' => '12:00:00', 'ruang' => 'Ruang Seminar 1'],
            ['tanggal' => '2025-06-04', 'waktu' => '13:00:00', 'ruang' => 'Ruang Seminar 2'],
            ['tanggal' => '2025-06-05', 'waktu' => '14:00:00', 'ruang' => 'Ruang Seminar 3'],
            ['tanggal' => '2025-06-05', 'waktu' => '13:00:00', 'ruang' => 'Ruang Seminar 1'],
        ];

        $jadwal = [];
        foreach (range(1, 10) as $index) {
            $pengajuan = \App\Models\PengajuanSempro::find($index);
            if (!$pengajuan) {
                throw new \Exception("PengajuanSempro ID {$index} tidak ditemukan.");
            }

            // Get supervisor ID to avoid assigning them as examiners
            $dosenPembimbingId = $pengajuan->dosen_pembimbing_id;

            // Get 3 examiners for the bidang keilmuan, excluding the supervisor
            $dosenPenguji = Dosen::where('bidang_keilmuan_id', $pengajuan->bidang_keilmuan_id)
                ->whereIn('id', DosenPenguji::pluck('dosen_id'))
                ->where('id', '!=', $dosenPembimbingId)
                ->inRandomOrder()
                ->take(3)
                ->pluck('id')
                ->toArray();

            if (count($dosenPenguji) < 3) {
                throw new \Exception("Tidak cukup dosen penguji untuk bidang keilmuan ID {$pengajuan->bidang_keilmuan_id}.");
            }

            $jadwal[] = [
                'pengajuan_sempro_id' => $index,
                'tanggal' => $scheduleDetails[$index - 1]['tanggal'],
                'waktu' => $scheduleDetails[$index - 1]['waktu'],
                'ruang' => $scheduleDetails[$index - 1]['ruang'],
                'dosen_penguji_1' => $dosenPenguji[0],
                'dosen_penguji_2' => $dosenPenguji[1],
                'dosen_penguji_3' => $dosenPenguji[2],
                'status' => in_array($index, [1, 2, 3, 4]) ? 'selesai' : (in_array($index, [5, 6]) ? 'dijadwalkan' : 'diproses'),
            ];
        }

        foreach ($jadwal as $data) {
            DB::transaction(function () use ($data) {
                // Create JadwalSempro
                $jadwalSempro = JadwalSempro::create($data);

                // Define approval status based on jadwal_sempro status
                $approvalStatuses = [];
                if ($data['status'] === 'diproses') {
                    // All pending for 'diproses'
                    $approvalStatuses = ['pending', 'pending', 'pending'];
                } else {
                    $approvalStatuses = ['setuju', 'setuju', 'setuju'];
                }

                // Create JadwalSemproApproval for each dosen penguji
                $approvals = [
                    [
                        'jadwal_sempro_id' => $jadwalSempro->id,
                        'dosen_id' => $data['dosen_penguji_1'],
                        'status' => $approvalStatuses[0],
                        'approved_at' => $approvalStatuses[0] === 'pending' ? null : now(),
                    ],
                    [
                        'jadwal_sempro_id' => $jadwalSempro->id,
                        'dosen_id' => $data['dosen_penguji_2'],
                        'status' => $approvalStatuses[1],
                        'approved_at' => $approvalStatuses[1] === 'pending' ? null : now(),
                    ],
                    [
                        'jadwal_sempro_id' => $jadwalSempro->id,
                        'dosen_id' => $data['dosen_penguji_3'],
                        'status' => $approvalStatuses[2],
                        'approved_at' => $approvalStatuses[2] === 'pending' ? null : now(),
                    ],
                ];

                JadwalSemproApproval::insert($approvals);
            });
        }
    }
}
