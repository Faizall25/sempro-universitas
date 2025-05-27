@extends('admin.layouts.main')

@section('title', __('Daftar Mahasiswa'))

@section('content')
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Mahasiswa</h2>
        <div class="flex justify-between items-center mb-4">
            {{-- <a href="{{ route('admin.mahasiswa.create') }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out"
                data-tooltip="Tambah mahasiswa baru">
                <i class="fas fa-user-plus mr-2"></i> Tambah Mahasiswa
            </a> --}}
            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.mahasiswa.index') }}">
                <div class="flex items-center">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari nama, NIM, email, atau program studi..."
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-4 rounded-lg shadow-sm"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($mahasiswa->isEmpty())
            <p class="text-gray-500 italic">Belum ada mahasiswa yang terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">NIM</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Program Studi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Fakultas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tahun Masuk</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswa as $index => $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 text-gray-700">{{ $index + $mahasiswa->firstItem() }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    @if ($item->user)
                                        {{ $item->deleted_at ? 'Mahasiswa Tidak Tersedia (' . $item->user->name . ')' : $item->user->name }}
                                    @else
                                        Mahasiswa Tidak Tersedia
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->nim }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->user ? $item->user->email : '-' }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->program_studi }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->fakultas }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->tahun_masuk }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.mahasiswa.edit', $item->id) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out"
                                        data-tooltip="Edit data mahasiswa">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    {{-- <form action="{{ route('admin.mahasiswa.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out"
                                            data-tooltip="Hapus mahasiswa"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $mahasiswa->appends(['search' => $search])->links() }}
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
