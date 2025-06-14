@extends('dosen.layouts.main')

@section('title', 'Informasi Pengajuan')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Navbar Tabs -->
        <div class="flex space-x-2 mb-6">
            <a href="{{ route('dosen.informasi_pengajuan.index', ['tab' => 'seminar-proposal']) }}"
                class="px-4 py-2 rounded-lg {{ $tab === 'seminar-proposal' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Seminar Proposal
            </a>
            <a href="{{ route('dosen.informasi_pengajuan.index', ['tab' => 'seminar-hasil']) }}"
                class="px-4 py-2 rounded-lg {{ $tab === 'seminar-hasil' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Seminar Hasil
            </a>
            <a href="{{ route('dosen.informasi_pengajuan.index', ['tab' => 'sidang-skripsi']) }}"
                class="px-4 py-2 rounded-lg {{ $tab === 'sidang-skripsi' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Sidang Skripsi
            </a>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Konten -->
        @if ($tab === 'seminar-proposal')
            @if ($jadwalSempro->isEmpty())
                <div class="bg-gray-100 text-gray-500 px-4 py-3 rounded-lg text-center">
                    <p class="text-sm">Belum Ada Pengajuan</p>
                </div>
            @else
                <div style="background-color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.05); 
                        border-radius: 8px; overflow: hidden;">
                <div style="background-color: #006066; color: white; padding: 16px;">
                    <h3 style="font-size: 18px; font-weight: 600;">Jadwal Seminar Proposal (Penguji)</h3>
                </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Judul</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Ruang</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalSempro as $index => $jadwal)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            {{ $jadwal->pengajuanSempro->mahasiswa->user->name ?? 'Tidak Diketahui' }}</td>
                                        <td class="px-6 py-4">{{ $jadwal->pengajuanSempro->judul ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="px-6 py-4">{{ $jadwal->tanggal->format('d M Y') }}</td>
                                        <td class="px-6 py-4">{{ $jadwal->waktu->format('H:i') }}</td>
                                        <td class="px-6 py-4">{{ $jadwal->ruang }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $approval = $jadwal->approvals->first();
                                                $status = $approval ? $approval->status : 'pending';
                                            @endphp
                                            <span
                                                class="badge {{ $status === 'pending' ? 'bg-yellow-200 text-yellow-800' : ($status === 'setuju' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                                {{ ucwords($status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if (!$approval || $approval->status === 'pending')
                                                <a href="{{ route('dosen.approve-jadwal-sempro', $jadwal->id) }}"
                                                    class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 mr-2">Setuju</a>
                                                <a href="{{ route('dosen.reject-jadwal-sempro', $jadwal->id) }}"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Tolak</a>
                                            @else
                                                <span class="text-gray-500 italic">Sudah Diproses</span>
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
            <div class="bg-gray-100 text-gray-500 px-4 py-3 rounded-lg text-center">
                <p class="text-sm">Fitur {{ ucwords(str_replace('-', ' ', $tab)) }} belum tersedia.</p>
            </div>
        @endif
    </div>
@endsection
