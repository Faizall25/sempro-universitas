@extends('admin.layouts.main')

@section('title', 'Jadwal Sempro')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Navbar -->
        <div class="mb-6">
            <ul class="flex border-b border-gray-200">
                <li class="mr-1">
                    <a href="#mahasiswa" id="tab-mahasiswa"
                        class="inline-block px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 {{ request()->query('tab', 'mahasiswa') == 'mahasiswa' ? 'active-tab' : '' }}"
                        onclick="showTab('mahasiswa')">Mahasiswa</a>
                </li>
                <li class="mr-1">
                    <a href="#dosen" id="tab-dosen"
                        class="inline-block px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 {{ request()->query('tab') == 'dosen' ? 'active-tab' : '' }}"
                        onclick="showTab('dosen')">Dosen</a>
                </li>
            </ul>
        </div>

        <!-- Tab Mahasiswa -->
        <div id="mahasiswa"
            class="tab-content {{ request()->query('tab', 'mahasiswa') == 'mahasiswa' ? 'block' : 'hidden' }}">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Jadwal Sempro - Mahasiswa</h2>
                <a href="{{ route('admin.jadwal.sempro.create') }}"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out"
                    data-tooltip="Tambah jadwal sempro baru">
                    <i class="fas fa-plus mr-2"></i> Tambah Jadwal
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg shadow-sm"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                                    <td class="px-6 py-4 text-gray-700">{{ $item->pengajuanSempro->judul ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        Penguji 1: {{ $item->dosenPenguji1->user->name ?? 'N/A' }}<br>
                                        <hr style="border-top: 3px solid #bbb">
                                        Penguji 2: {{ $item->dosenPenguji2->user->name ?? 'N/A' }}<br>
                                        <hr style="border-top: 3px solid #bbb">
                                        Penguji 3: {{ $item->dosenPenguji3->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <span
                                            class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ $item->status == 'dijadwalkan' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <a href="{{ route('admin.jadwal.sempro.edit', $item->id) }}"
                                            class="relative px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out"
                                            data-tooltip="Edit jadwal">
                                            <i class="fas fa-edit"></i>
                                            <span class="tooltip">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.jadwal.sempro.destroy', $item->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="relative px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out"
                                                data-tooltip="Hapus jadwal"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
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

        <!-- Tab Dosen -->
        <div id="dosen" class="tab-content {{ request()->query('tab') == 'dosen' ? 'block' : 'hidden' }}">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Jadwal Sempro - Approval Dosen</h2>
                <a href="{{ route('admin.jadwal.sempro.approval.create') }}"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out"
                    data-tooltip="Tambah approval dosen">
                    <i class="fas fa-plus mr-2"></i> Tambah Approval
                </a>
            </div>

            @if ($jadwal->isEmpty())
                <p class="text-gray-500 italic">Belum ada jadwal sempro yang terdaftar.</p>
            @else
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="min-w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Judul Pengajuan</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold uppercase">Dosen Penguji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $index => $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                                    <td class="px-6 py-4 text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $item->pengajuanSempro->judul ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end">
                                            <div class="text-right">
                                                Penguji 1: {{ $item->dosenPenguji1->user->name ?? 'N/A' }}
                                                ({{ $item->approvals->where('dosen_id', $item->dosen_penguji_1)->first()->status ?? 'null' }})
                                            </div>
                                            <a href="{{ route('admin.jadwal.sempro.approval.edit.penguji', ['jadwal' => $item->id, 'penguji' => 1]) }}"
                                                class="ml-2 px-2 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 ease-in-out"
                                                data-tooltip="Ganti Penguji 1">
                                                <i class="fas fa-user-edit"></i>
                                                <span class="tooltip">Ganti</span>
                                            </a>
                                        </div>
                                        <div class="flex items-center justify-end mt-2">
                                            <div class="text-right">
                                                Penguji 2: {{ $item->dosenPenguji2->user->name ?? 'N/A' }}
                                                ({{ $item->approvals->where('dosen_id', $item->dosen_penguji_2)->first()->status ?? 'null' }})
                                            </div>
                                            <a href="{{ route('admin.jadwal.sempro.approval.edit.penguji', ['jadwal' => $item->id, 'penguji' => 2]) }}"
                                                class="ml-2 px-2 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 ease-in-out"
                                                data-tooltip="Ganti Penguji 2">
                                                <i class="fas fa-user-edit"></i>
                                                <span class="tooltip">Ganti</span>
                                            </a>
                                        </div>
                                        <div class="flex items-center justify-end mt-2">
                                            <div class="text-right">
                                                Penguji 3: {{ $item->dosenPenguji3->user->name ?? 'N/A' }}
                                                ({{ $item->approvals->where('dosen_id', $item->dosen_penguji_3)->first()->status ?? 'null' }})
                                            </div>
                                            <a href="{{ route('admin.jadwal.sempro.approval.edit.penguji', ['jadwal' => $item->id, 'penguji' => 3]) }}"
                                                class="ml-2 px-2 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 ease-in-out"
                                                data-tooltip="Ganti Penguji 3">
                                                <i class="fas fa-user-edit"></i>
                                                <span class="tooltip">Ganti</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $jadwal->appends(['search' => $search, 'tab' => 'dosen'])->links() }}
                    </div>
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

        th,
        td {
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

        .tab-content {
            display: none;
        }

        .tab-content.block {
            display: block;
        }

        .active-tab {
            border-bottom: 2px solid #2563eb;
            color: #2563eb;
        }
    </style>

    @push('scripts')
        <script>
            function showTab(tab) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('block'));
                document.getElementById(tab).classList.add('block');

                // Update navbar active state
                document.querySelectorAll('ul li a').forEach(link => {
                    link.classList.remove('active-tab');
                    link.classList.add('text-gray-600', 'hover:text-blue-600');
                });
                const activeLink = document.getElementById(`tab-${tab}`);
                activeLink.classList.add('active-tab');
                activeLink.classList.remove('text-gray-600', 'hover:text-blue-600');

                // Update all links in tab content to reflect current tab
                document.querySelectorAll('.tab-content a').forEach(link => {
                    link.href = link.href.split('?')[0] + '?tab=' + tab;
                });

                // Update URL without reloading
                const url = new URL(window.location);
                url.searchParams.set('tab', tab);
                window.history.pushState({}, '', url);
            }

            // Initialize tab based on URL parameter
            document.addEventListener('DOMContentLoaded', () => {
                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab') || 'mahasiswa';
                showTab(tab);
            });

            // Handle tooltip creation
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
