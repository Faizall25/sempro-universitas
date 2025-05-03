@extends('admin.layouts.main')

@section('title', 'Jadwal Sempro')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Jadwal Sempro</h2>
        <a href="{{ route('admin.jadwal.sempro.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out" data-tooltip="Tambah jadwal sempro baru">
            <i class="fas fa-plus mr-2"></i> Tambah Jadwal
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($jadwal->isEmpty())
        <p class="text-gray-500 italic">Belum ada jadwal sempro yang terdaftar.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Ruang</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Pengajuan Sempro</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Dosen Penguji</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $index => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                            <td class="px-6 py-4 text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->tanggal->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->waktu->format('H:i') }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->ruang }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->pengajuanSempro->judul ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $item->dosenPenguji1->user->name ?? 'N/A' }}<br>
                                {{ $item->dosenPenguji2->user->name ?? 'N/A' }}<br>
                                {{ $item->dosenPenguji3->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <span class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ $item->status == 'dijadwalkan' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('admin.jadwal.sempro.edit', $item->id) }}" class="relative px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out" data-tooltip="Edit jadwal">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltip">Edit</span>
                                </a>
                                <form action="{{ route('admin.jadwal.sempro.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="relative px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out" data-tooltip="Hapus jadwal" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        <i class="fas fa-trash"></i>
                                        <span class="tooltip">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
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
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }
    tr:last-child td {
        border-bottom: none;
    }
    .tooltip {
        visibility: hidden;
        background-color: #1f2937;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 10px;
        position: absolute;
        z-index: 10;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 12px;
        white-space: nowrap;
    }
    [data-tooltip]:hover .tooltip {
        visibility: visible;
        opacity: 1;
    }
</style>

@push('scripts')
<script>
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        const tooltip = document.createElement('span');
        tooltip.className = 'tooltip';
        tooltip.innerText = element.getAttribute('data-tooltip');
        element.appendChild(tooltip);
        element.classList.add('relative');
    });
</script>
@endpush
@endsection