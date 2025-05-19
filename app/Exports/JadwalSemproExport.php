<?php

namespace App\Exports;

use App\Models\JadwalSempro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class JadwalSemproExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
{
    protected $startDate;
    protected $endDate;
    protected $status;

    public function __construct($startDate, $endDate, $status = null)
    {
        $this->startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $this->endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
        $this->status = $status;
    }

    public function collection()
    {
        $query = JadwalSempro::with(['pengajuanSempro.mahasiswa.user', 'dosenPenguji1.user', 'dosenPenguji2.user', 'dosenPenguji3.user'])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get()->map(function ($jadwal) {
            return [
                'ID' => $jadwal->id,
                'Mahasiswa' => $jadwal->pengajuanSempro->mahasiswa->user->name ?? '-',
                'Judul' => $jadwal->pengajuanSempro->judul ?? '-',
                'Tanggal' => $jadwal->tanggal->format('Y-m-d'),
                'Waktu' => $jadwal->waktu->format('H:i'),
                'Ruang' => $jadwal->ruang,
                'Dosen Penguji 1' => $jadwal->dosenPenguji1->user->name ?? '-',
                'Dosen Penguji 2' => $jadwal->dosenPenguji2->user->name ?? '-',
                'Dosen Penguji 3' => $jadwal->dosenPenguji3->user->name ?? '-',
                'Status' => ucfirst($jadwal->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mahasiswa',
            'Judul',
            'Tanggal',
            'Waktu',
            'Ruang',
            'Dosen Penguji 1',
            'Dosen Penguji 2',
            'Dosen Penguji 3',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2C81D4'],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Wrap text for Judul

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // ID
            'B' => 25, // Mahasiswa
            'C' => 40, // Judul
            'D' => 15, // Tanggal
            'E' => 10, // Waktu
            'F' => 15, // Ruang
            'G' => 25, // Dosen Penguji 1
            'H' => 25, // Dosen Penguji 2
            'I' => 25, // Dosen Penguji 3
            'J' => 15, // Status
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Tanggal
            'E' => NumberFormat::FORMAT_DATE_TIME3, // Waktu
        ];
    }
}
