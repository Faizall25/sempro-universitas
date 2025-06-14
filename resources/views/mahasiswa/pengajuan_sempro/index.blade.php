@extends('mahasiswa.layouts.main')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">SKRIPSI / TESIS / DISERTASI</h2>
            <div class="flex items-center space-x-4">
                @if ($canSubmit)
                    <button onclick="openCreateModal()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">Mulai
                        Pengajuan Bimbingan</button>
                @else
                    <button disabled class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">Mulai Pengajuan
                        Bimbingan</button>
                @endif
            </div>
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
        @if (!$canSubmit)
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <p class="text-sm">Anda tidak dapat mengajukan proposal baru saat status masih pending atau diterima. Tunggu
                    hingga ditolak atau selesai.</p>
            </div>
        @endif
        @if ($pengajuan->isEmpty())
            <div class="bg-gray-100 text-gray-500 px-4 py-3 rounded-lg text-center">
                <p class="text-sm">Belum Ada Pengajuan</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4 text-left">Judul</th>
                            <th class="py-2 px-4 text-left">Status</th>
                            <th class="py-2 px-4 text-left">Bidang Keilmuan</th>
                            <th class="py-2 px-4 text-left">Dosen Pembimbing</th>
                            <th class="py-2 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuan as $p)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4">{{ $p->judul }}</td>
                                <td class="py-2 px-4"><span
                                        class="badge {{ $p->status === 'pending' ? 'bg-yellow-200' : ($p->status === 'diterima' ? 'bg-green-200' : 'bg-red-200') }}">{{ $p->status }}</span>
                                </td>
                                <td class="py-2 px-4">{{ $p->bidangKeilmuan->name }}</td>
                                <td class="py-2 px-4">{{ $p->dosenPembimbing->user->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 flex space-x-2">
                                    @php
                                        $canEdit = $p->status === 'pending' && !$p->jadwalSempro;
                                    @endphp
                                    @if ($canEdit)
                                        <button onclick="openEditModal({{ $p->id }})"
                                            class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">Edit</button>
                                    @else
                                        <button disabled
                                            class="px-2 py-1 bg-gray-400 text-white rounded-lg cursor-not-allowed">Edit</button>
                                    @endif
                                    @if ($p->jadwalSempro)
                                        <button onclick="openViewModal({{ $p->id }})"
                                            class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal Create -->
    <div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div
            class="bg-white rounded-lg shadow-xl p-6 w-full max-w-3xl transform transition-all duration-300 scale-95 hover:scale-100">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Mulai Pengajuan Bimbingan</h3>
            <form id="createForm" action="{{ route('mahasiswa.pengajuan_sempro.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-medium mb-2">Judul</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('judul')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jurusan" class="block text-gray-700 font-medium mb-2">Jurusan</label>
                        <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('jurusan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="fakultas" class="block text-gray-700 font-medium mb-2">Fakultas</label>
                        <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('fakultas')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="bidang_keilmuan_id" class="block text-gray-700 font-medium mb-2">Bidang Keilmuan</label>
                        <select id="bidang_keilmuan_id" name="bidang_keilmuan_id"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Pilih Bidang Keilmuan --</option>
                            @foreach ($bidangKeilmuan as $bidang)
                                <option value="{{ $bidang->id }}"
                                    {{ old('bidang_keilmuan_id') == $bidang->id ? 'selected' : '' }}>{{ $bidang->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('bidang_keilmuan_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="dosen_pembimbing_id" class="block text-gray-700 font-medium mb-2">Dosen
                            Pembimbing</label>
                        <select id="dosen_pembimbing_id" name="dosen_pembimbing_id"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Pilih Dosen Pembimbing --</option>
                            @foreach ($dosenPembimbing as $dosen)
                                <option value="{{ $dosen->id }}" data-bidang-id="{{ $dosen->bidang_keilmuan_id }}"
                                    {{ old('dosen_pembimbing_id') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->user->name }} ({{ $dosen->bidangKeilmuan->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('dosen_pembimbing_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 col-span-2">
                        <label for="abstrak" class="block text-gray-700 font-medium mb-2">Abstrak</label>
                        <textarea id="abstrak" name="abstrak"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"
                            required>{{ old('abstrak') }}</textarea>
                        @error('abstrak')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                        onclick="closeCreateModal()">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Ajukan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach ($pengajuan as $p)
        <div id="editModal_{{ $p->id }}"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
            <div
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-3xl transform transition-all duration-300 scale-95 hover:scale-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Pengajuan Bimbingan</h3>
                <form id="editForm_{{ $p->id }}"
                    action="{{ route('mahasiswa.pengajuan_sempro.update', $p->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="judul_{{ $p->id }}"
                                class="block text-gray-700 font-medium mb-2">Judul</label>
                            <input type="text" id="judul_{{ $p->id }}" name="judul"
                                value="{{ old('judul', $p->judul) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('judul')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="jurusan_{{ $p->id }}"
                                class="block text-gray-700 font-medium mb-2">Jurusan</label>
                            <input type="text" id="jurusan_{{ $p->id }}" name="jurusan"
                                value="{{ old('jurusan', $p->jurusan) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('jurusan')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="fakultas_{{ $p->id }}"
                                class="block text-gray-700 font-medium mb-2">Fakultas</label>
                            <input type="text" id="fakultas_{{ $p->id }}" name="fakultas"
                                value="{{ old('fakultas', $p->fakultas) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('fakultas')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="bidang_keilmuan_id_{{ $p->id }}"
                                class="block text-gray-700 font-medium mb-2">Bidang Keilmuan</label>
                            <select id="bidang_keilmuan_id_{{ $p->id }}" name="bidang_keilmuan_id"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Bidang Keilmuan --</option>
                                @foreach ($bidangKeilmuan as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ old('bidang_keilmuan_id', $p->bidang_keilmuan_id) == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->name }}</option>
                                @endforeach
                            </select>
                            @error('bidang_keilmuan_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="dosen_pembimbing_id_{{ $p->id }}"
                                class="block text-gray-700 font-medium mb-2">Dosen Pembimbing</label>
                            <select id="dosen_pembimbing_id_{{ $p->id }}" name="dosen_pembimbing_id"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Dosen Pembimbing --</option>
                                @foreach ($dosenPembimbing as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        data-bidang-id="{{ $dosen->bidang_keilmuan_id }}"
                                        {{ old('dosen_pembimbing_id', $p->dosen_pembimbing_id) == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->user->name }} ({{ $dosen->bidangKeilmuan->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('dosen_pembimbing_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 col-span-2">
                            <label for="abstrak_{{ $p->id }}"
                                class="block text-gray-700 font-medium mb-2">Abstrak</label>
                            <textarea id="abstrak_{{ $p->id }}" name="abstrak"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"
                                required>{{ old('abstrak', $p->abstrak) }}</textarea>
                            @error('abstrak')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                            onclick="closeEditModal({{ $p->id }})">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Modal View Jadwal Sempro -->
    @foreach ($pengajuan as $p)
        @if ($p->jadwalSempro)
            <div id="viewModal_{{ $p->id }}"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
                <div
                    class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl transform transition-all duration-300 scale-95 hover:scale-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Jadwal Seminar Proposal</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Judul</label>
                            <p class="text-gray-600">{{ $p->judul }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Tanggal</label>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($p->jadwalSempro->tanggal)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Waktu</label>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($p->jadwalSempro->waktu)->format('H:i') }} - {{ \Carbon\Carbon::parse($p->jadwalSempro->waktu)->addHour()->format('H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Ruang</label>
                            <p class="text-gray-600">{{ $p->jadwalSempro->ruang }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Status</label>
                            <p class="text-gray-600">{{ ucfirst($p->jadwalSempro->status) }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Dosen Penguji 1</label>
                            <p class="text-gray-600">{{ $p->jadwalSempro->dosenPenguji1->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Dosen Penguji 2</label>
                            <p class="text-gray-600">{{ $p->jadwalSempro->dosenPenguji2->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Dosen Penguji 3</label>
                            <p class="text-gray-600">{{ $p->jadwalSempro->dosenPenguji3->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                            onclick="closeViewModal({{ $p->id }})">Tutup</button>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <script>
        // Fungsi untuk membuka dan menutup modal
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            filterDosenPembimbing('bidang_keilmuan_id', 'dosen_pembimbing_id');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createForm').reset();
            filterDosenPembimbing('bidang_keilmuan_id', 'dosen_pembimbing_id');
        }

        function openEditModal(id) {
            document.getElementById('editModal_' + id).classList.remove('hidden');
            filterDosenPembimbing('bidang_keilmuan_id_' + id, 'dosen_pembimbing_id_' + id);
        }

        function closeEditModal(id) {
            document.getElementById('editModal_' + id).classList.add('hidden');
        }

        function openViewModal(id) {
            document.getElementById('viewModal_' + id).classList.remove('hidden');
        }

        function closeViewModal(id) {
            document.getElementById('viewModal_' + id).classList.add('hidden');
        }

        // Fungsi untuk memfilter dosen berdasarkan bidang keilmuan
        function filterDosenPembimbing(bidangId, dosenId) {
            const bidangSelect = document.getElementById(bidangId);
            const dosenSelect = document.getElementById(dosenId);
            const selectedBidang = bidangSelect.value;
            const selectedDosen = dosenSelect.value;

            Array.from(dosenSelect.options).forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });

            Array.from(dosenSelect.options).forEach(option => {
                if (option.value && option.dataset.bidangId === selectedBidang) {
                    option.style.display = 'block';
                }
                if (option.value === selectedDosen) {
                    option.style.display = 'block';
                }
            });

            if (selectedDosen) {
                const selectedOption = dosenSelect.querySelector(`option[value="${selectedDosen}"]`);
                if (selectedOption && selectedOption.dataset.bidangId !== selectedBidang) {
                    dosenSelect.value = '';
                }
            }
        }

        // Tambahkan event listener untuk semua select bidang keilmuan
        document.addEventListener('DOMContentLoaded', () => {
            const bidangCreate = document.getElementById('bidang_keilmuan_id');
            if (bidangCreate) {
                bidangCreate.addEventListener('change', () => {
                    filterDosenPembimbing('bidang_keilmuan_id', 'dosen_pembimbing_id');
                });
                filterDosenPembimbing('bidang_keilmuan_id', 'dosen_pembimbing_id');
            }

            @foreach ($pengajuan as $p)
                const bidangEdit_{{ $p->id }} = document.getElementById(
                    'bidang_keilmuan_id_{{ $p->id }}');
                if (bidangEdit_{{ $p->id }}) {
                    bidangEdit_{{ $p->id }}.addEventListener('change', () => {
                        filterDosenPembimbing('bidang_keilmuan_id_{{ $p->id }}',
                            'dosen_pembimbing_id_{{ $p->id }}');
                    });
                    filterDosenPembimbing('bidang_keilmuan_id_{{ $p->id }}',
                        'dosen_pembimbing_id_{{ $p->id }}');
                }
            @endforeach
        });
    </script>
@endsection