@extends('admin.layouts.main')

@section('title', 'Dosen Penguji')

@section('content')
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dosen Penguji</h2>
        <a href="{{ route('admin.dosen.penguji.create') }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mb-4 transition duration-300 ease-in-out"
            data-tooltip="Tambah dosen penguji baru">
            <i class="fas fa-user-plus mr-2"></i> Tambah Dosen
        </a>
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-4 rounded-lg shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($dosen->isEmpty())
            <p class="text-gray-500 italic">Belum ada dosen penguji yang terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">NIP</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Bidang Keilmuan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dosen as $index => $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 text-gray-700">{{ $index + $dosen->firstItem() }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->user->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->nip }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->bidangKeilmuan->name }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $item->penguji->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <form action="{{ route('admin.dosen.penguji.toggle', $item->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1 {{ $item->penguji->status_aktif ? 'bg-green-500 hover:bg-green-600' : 'bg-yellow-500 hover:bg-yellow-600' }} text-white rounded-lg transition duration-300 ease-in-out"
                                            data-tooltip="{{ $item->penguji->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }} status dosen">
                                            <i
                                                class="fas {{ $item->penguji->status_aktif ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.dosen.penguji.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out"
                                            data-tooltip="Hapus dosen dari daftar penguji"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini dari daftar penguji?')">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $dosen->appends(['search' => $search])->links() }}
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
