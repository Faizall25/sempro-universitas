@extends('admin.layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Dashboard Admin</h2>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <!-- Kartu Mahasiswa -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #d0f0f0;">
                    <i class="fas fa-users text-2xl" style="color: #006066;"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Mahasiswa</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalMahasiswa }}</p>
                </div>
            </div>
        </div>

        <!-- Kartu Dosen -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #d0f0f0;">
                    <i class="fas fa-chalkboard-teacher text-2xl" style="color: #006066;"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Dosen</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalDosen }}</p>
                </div>
            </div>
        </div>

        <!-- Kartu Pengajuan Sempro -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #d0f0f0;">
                    <i class="fas fa-file-alt text-2xl" style="color: #006066;"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Pengajuan Sempro</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPengajuan }}</p>
                </div>
            </div>
        </div>

        <!-- Kartu Jadwal Sempro -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #d0f0f0;">
                    <i class="fas fa-calendar-alt text-2xl" style="color: #006066;"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Jadwal Sempro</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalJadwal }}</p>
                </div>
            </div>
        </div>

        <!-- Kartu Hasil Sempro -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full" style="background-color: #d0f0f0;">
                    <i class="fas fa-check-circle text-2xl" style="color: #006066;"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Hasil Sempro</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalHasil }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Status Hasil Sempro</h3>
        <canvas id="statusChart" height="100"></canvas>
    </div>

    <!-- Navigasi Cepat -->
    <div class="flex space-x-4 mb-8">
        <a href="{{ route('admin.jadwal.sempro.index') }}" class="inline-block px-6 py-3 text-white rounded-lg hover:opacity-90 transition duration-200" style="background-color: #006066;">
            <i class="fas fa-calendar mr-2"></i> Kelola Jadwal Sempro
        </a>
        <a href="{{ route('admin.hasil.sempro.index') }}" class="inline-block px-6 py-3 text-white rounded-lg hover:opacity-90 transition duration-200" style="background-color: #006066;">
            <i class="fas fa-file-alt mr-2"></i> Kelola Hasil Sempro
        </a>
    </div>

    <!-- Jadwal Mendatang -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4" style="background-color: #006066; color: white;">
            <h3 class="text-lg font-semibold">Jadwal Sempro Mendatang (7 Hari ke Depan)</h3>
        </div>
        @if ($jadwalMendatang->isEmpty())
            <p class="px-6 py-4 text-gray-500 italic">Tidak ada jadwal sempro mendatang dalam 7 hari ke depan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-white">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-white">Judul Pengajuan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-white">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-white">Waktu</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-white">Ruang</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-white">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalMendatang as $index => $jadwal)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $jadwal->pengajuanSempro->judul ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $jadwal->tanggal->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $jadwal->waktu->format('H:i') }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $jadwal->ruang }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    <span class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ $jadwal->status == 'dijadwalkan' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucwords($jadwal->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
    table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        border-bottom: 1px solid #e5e7eb;
    }
    th {
        background: linear-gradient(135deg, #004d4d 0%, #009999 100%);
    }
    tr:last-child td {
        border-bottom: none;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Lolos Tanpa Revisi', 'Revisi Minor', 'Revisi Mayor', 'Tidak Lolos'],
            datasets: [{
                data: [
                    {{ $statusCounts['lolos_tanpa_revisi'] ?? 0 }},
                    {{ $statusCounts['revisi_minor'] ?? 0 }},
                    {{ $statusCounts['revisi_mayor'] ?? 0 }},
                    {{ $statusCounts['tidak_lolos'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(0, 102, 102, 0.6)',
                    'rgba(0, 153, 153, 0.6)',
                    'rgba(102, 204, 204, 0.6)',
                    'rgba(204, 255, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(0, 102, 102, 1)',
                    'rgba(0, 153, 153, 1)',
                    'rgba(102, 204, 204, 1)',
                    'rgba(204, 255, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribusi Status Hasil Sempro',
                    color: '#006066'
                }
            }
        }
    });
</script>
@endpush
@endsection
