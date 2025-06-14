@extends('admin.layouts.main')

@section('title', 'Hasil Sempro')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Hasil Sempro</h2>
            <a href="{{ route('admin.hasil.sempro.create') }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out"
                data-tooltip="Tambah hasil sempro baru">
                <i class="fas fa-plus mr-2"></i> Tambah Hasil
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

        @if ($hasil->isEmpty())
            <p class="text-gray-500 italic">Belum ada hasil sempro yang terdaftar.</p>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Jadwal Sempro</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Nilai Penguji</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Rata-rata</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">File Revisi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil as $index => $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 text-gray-700">{{ $index + $hasil->firstItem() }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $item->jadwalSempro->pengajuanSempro->judul ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $item->nilai_peng1 }} | {{ $item->nilai_peng2 }} | {{ $item->nilai_peng3 }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ number_format($item->rata_rata, 2) }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    <span
                                        class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ $item->status == 'lolos_tanpa_revisi' ? 'bg-green-100 text-green-800' : ($item->status == 'revisi_minor' ? 'bg-yellow-100 text-yellow-800' : ($item->status == 'revisi_mayor' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ str_replace('_', ' ', ucwords($item->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    @if ($item->revisi_file_path)
                                        <a href="{{ Storage::url($item->revisi_file_path) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat File</a>
                                    @else
                                        Tidak ada
                                    @endif
                                    <button
                                        class="relative px-3 py-1 {{ in_array($item->status, ['lolos_tanpa_revisi', 'tidak_lolos']) ? 'bg-gray-500' : 'bg-green-500' }} text-white rounded-lg {{ in_array($item->status, ['lolos_tanpa_revisi', 'tidak_lolos']) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-600' }} transition duration-300 ease-in-out"
                                        data-tooltip="Upload revisi"
                                        {{ in_array($item->status, ['lolos_tanpa_revisi', 'tidak_lolos']) ? 'disabled' : '' }}
                                        onclick="openModal('uploadModal-{{ $item->id }}')">
                                        <i class="fas fa-upload"></i>
                                        <span class="tooltip">Upload</span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.hasil.sempro.edit', $item->id) }}"
                                        class="relative px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out"
                                        data-tooltip="Edit hasil">
                                        <i class="fas fa-edit"></i>
                                        <span class="tooltip">Edit</span>
                                    </a>
                                    <form action="{{ route('admin.hasil.sempro.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out"
                                            data-tooltip="Hapus hasil"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus hasil ini?')">
                                            <i class="fas fa-trash"></i>
                                            <span class="tooltip">Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal untuk Upload Revisi -->
                            <div id="uploadModal-{{ $item->id }}"
                                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
                                <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">Upload File Revisi</h3>
                                        <button class="text-gray-500 hover:text-gray-700"
                                            onclick="closeModal('uploadModal-{{ $item->id }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.hasil.sempro.upload-revisi', $item->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="revisi_file_{{ $item->id }}"
                                                class="block text-gray-700 font-medium mb-2">File Revisi (PDF, maks
                                                5MB)</label>
                                            <input type="file" id="revisi_file_{{ $item->id }}" name="revisi_file"
                                                accept=".pdf"
                                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @error('revisi_file')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button"
                                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200"
                                                onclick="closeModal('uploadModal-{{ $item->id }}')">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                                <i class="fas fa-upload mr-2"></i> Unggah
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $hasil->appends(['search' => $search])->links() }}
                </div>
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

            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }
        </script>
    @endpush
@endsection
