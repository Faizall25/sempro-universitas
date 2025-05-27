@extends('dosen.layouts.main')

@section('title', 'Informasi Pengajuan')

@section('content')
<div class="container mx-auto p-6">
    <!-- Navbar Tabs -->
    <div class="flex space-x-2 mb-6">
        <a href="{{ route('dosen.informasi_pengajuan.index', ['tab' => 'seminar-proposal']) }}"
           style="padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500; 
                  background-color: {{ $tab === 'seminar-proposal' ? '#006066' : '#e5e5e5' }}; 
                  color: {{ $tab === 'seminar-proposal' ? '#fff' : '#333' }};">
            Seminar Proposal
        </a>
        <a href="{{ route('dosen.informasi_pengajuan.index', ['tab' => 'seminar-hasil']) }}"
           style="padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500; 
                  background-color: {{ $tab === 'seminar-hasil' ? '#006066' : '#e5e5e5' }}; 
                  color: {{ $tab === 'seminar-hasil' ? '#fff' : '#333' }};">
            Seminar Hasil
        </a>
        <a href="{{ route('dosen.informasi_pengajuan.index', ['tab' => 'sidang-skripsi']) }}"
           style="padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500; 
                  background-color: {{ $tab === 'sidang-skripsi' ? '#006066' : '#e5e5e5' }}; 
                  color: {{ $tab === 'sidang-skripsi' ? '#fff' : '#333' }};">
            Sidang Skripsi
        </a>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; 
                    padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
            <p style="font-size: 14px;">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b; 
                    padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
            <p style="font-size: 14px;">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Konten -->
    @if ($tab === 'seminar-proposal')
        @if ($jadwalSempro->isEmpty())
            <div style="background-color: #f3f4f6; color: #6b7280; padding: 12px 16px; 
                        border-radius: 8px; text-align: center;">
                <p style="font-size: 14px;">Belum Ada Pengajuan</p>
            </div>
        @else
            <div style="background-color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.05); 
                        border-radius: 8px; overflow: hidden;">
                <div style="background-color: #006066; color: white; padding: 16px;">
                    <h3 style="font-size: 18px; font-weight: 600;">Seminar Proposal</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background-color: #f3f4f6;">
                            <tr>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">No</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Mahasiswa</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Judul</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Tanggal</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Waktu</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Ruang</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Status</th>
                                <th style="padding: 16px; text-align: left; font-size: 14px; font-weight: 600;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalSempro as $index => $jadwal)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 16px; color: #000;">{{ $index + 1 }}</td>
                                    <td style="padding: 16px; color: #000;">{{ $jadwal->pengajuanSempro->mahasiswa->user->name ?? 'Tidak Diketahui' }}</td>
                                    <td style="padding: 16px; color: #000;">{{ $jadwal->pengajuanSempro->judul ?? 'Tidak Diketahui' }}</td>
                                    <td style="padding: 16px; color: #000;">{{ $jadwal->tanggal->format('d M Y') }}</td>
                                    <td style="padding: 16px; color: #000;">{{ $jadwal->waktu->format('H:i') }}</td>
                                    <td style="padding: 16px; color: #000;">{{ $jadwal->ruang }}</td>
                                    <td style="padding: 16px;">
                                        @php
                                            $approval = $jadwal->approvals->first();
                                            $status = $approval ? $approval->status : 'pending';
                                            $badgeStyle = match($status) {
                                                'pending' => 'background-color:#fefcbf; color:#92400e;',
                                                'setuju' => 'background-color:#c6f6d5; color:#276749;',
                                                'tolak' => 'background-color:#fecaca; color:#991b1b;',
                                                default => 'background-color:#e5e7eb; color:#4b5563;',
                                            };
                                        @endphp
                                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; {{ $badgeStyle }}">
                                            {{ ucwords($status) }}
                                        </span>
                                    </td>
                                    <td style="padding: 16px;">
                                        @if (!$approval || $approval->status === 'pending')
                                            <a href="{{ route('dosen.approve-jadwal-sempro', $jadwal->id) }}"
                                            style="display: inline-block; padding: 6px 12px; border-radius: 6px; background-color: #006066; color: white; text-decoration: none; margin-bottom: 6px;">
                                                Setuju
                                            </a><br>
                                            <a href="{{ route('dosen.reject-jadwal-sempro', $jadwal->id) }}"
                                            style="display: inline-block; padding: 6px 12px; border-radius: 6px; background-color: #dc2626; color: white; text-decoration: none;">
                                                Tolak
                                            </a>
                                        @else
                                            <span style="color: #6b7280; font-style: italic;">Sudah Diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @else
        <div style="background-color: #f3f4f6; color: #6b7280; padding: 12px 16px; border-radius: 8px; text-align: center;">
            <p style="font-size: 14px;">Fitur {{ ucwords(str_replace('-', ' ', $tab)) }} belum tersedia.</p>
        </div>
    @endif
</div>
@endsection
