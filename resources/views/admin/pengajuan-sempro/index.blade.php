@extends('admin.layouts.main')

@section('title', 'Pengajuan Sempro')

@section('content')
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Pengajuan Sempro</h2>
        <a href="{{ route('admin.pengajuan-sempro.create') }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mb-4 transition duration-300 ease-in-out"
            data-tooltip="Tambah pengajuan sempro baru">
            <i class="fas fa-plus mr-2"></i> Tambah Pengajuan
        </a>
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-4 rounded-lg shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($pengajuanSempro->isEmpty())
            <p class="text-gray-500 italic">Belum ada pengajuan sempro yang terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Judul</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Bidang Keilmuan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Jurusan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Fakultas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pembimbing</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuanSempro as $index => $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 text-gray-700">{{ $index + $pengajuanSempro->firstItem() }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    @if ($item->mahasiswa && $item->mahasiswa->user)
                                        {{ $item->mahasiswa->deleted_at ? 'Mahasiswa Tidak Tersedia (' . $item->mahasiswa->user->name . ')' : $item->mahasiswa->user->name }}
                                    @else
                                        Mahasiswa Tidak Tersedia
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->judul }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->jurusan }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->fakultas }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    @if ($item->dosenPembimbing && $item->dosenPembimbing->user)
                                        {{ $item->dosenPembimbing->deleted_at ? 'Dosen Tidak Tersedia (' . $item->dosenPembimbing->user->name . ')' : $item->dosenPembimbing->user->name }}
                                    @else
                                        Dosen Tidak Tersedia
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $item->bidangKeilmuan ? $item->bidangKeilmuan->name : 'Tidak Tersedia' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ ucfirst($item->status) }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.pengajuan-sempro.edit', $item->id) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out"
                                        data-tooltip="Edit pengajuan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pengajuan-sempro.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out"
                                            data-tooltip="Hapus pengajuan"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $pengajuanSempro->appends(['search' => $search])->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            text-transform: uppercase;
            letter-spacing: 0.05em;
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
