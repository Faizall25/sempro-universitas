@extends('dosen.layouts.main')

@section('title', 'Jadwal Perkuliahan')

@section('content')
<div class="container mx-auto p-6">
    <!-- Navbar Tabs -->
    <div class="flex space-x-2 mb-6">
        <a href="{{ route('dosen.jadwal_perkuliahan.index', ['tab' => 'seluruh-jadwal']) }}"
           class="px-4 py-2 rounded-lg {{ $tab === 'seluruh-jadwal' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Seluruh Pemasaran Jadwal
        </a>
        <a href="{{ route('dosen.jadwal_perkuliahan.index', ['tab' => 'jadwal-dosen']) }}"
           class="px-4 py-2 rounded-lg {{ $tab === 'jadwal-dosen' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Jadwal Perkuliahan Saya
        </a>
    </div>

    <!-- Konten -->
    @if ($jadwal->isEmpty())
        <div class="bg-gray-100 text-gray-500 px-4 py-3 rounded-lg text-center">
            <p class="text-sm">Belum Ada Jadwal</p>
        </div>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-200 text-gray-700">
                <h3 class="text-lg font-semibold">{{ $tab === 'seluruh-jadwal' ? 'Seluruh Pemasaran Jadwal' : 'Jadwal Perkuliahan Sesuai Dosen' }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Hari</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Pukul</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Kelas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Ruang</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">SKS</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Dosen</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Asisten Dosen</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">MK Jurusan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $index => $j)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $j->hari }}</td>
                                <td class="px-6 py-4">{{ $j->pukul->format('H:i') }}</td>
                                <td class="px-6 py-4">{{ $j->kelas }}</td>
                                <td class="px-6 py-4">{{ $j->ruang }}</td>
                                <td class="px-6 py-4">{{ $j->kode }}</td>
                                <td class="px-6 py-4">{{ $j->mata_kuliah }}</td>
                                <td class="px-6 py-4">{{ $j->sks }}</td>
                                <td class="px-6 py-4">{{ $j->dosen->user->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $j->asisten_dosen ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $j->mk_jurusan }}</td>
                                <td class="px-6 py-4">{{ $j->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection