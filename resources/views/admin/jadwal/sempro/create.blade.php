@extends('admin.layouts.main')

@section('title', 'Tambah Jadwal Sempro')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Tambah Jadwal Sempro</h2>
                <a href="{{ route('admin.jadwal.sempro.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.jadwal.sempro.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="pengajuan_sempro_id" class="block text-gray-700 font-medium mb-2">Pengajuan Sempro</label>
                    <select id="pengajuan_sempro_id" name="pengajuan_sempro_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        onchange="updateBidangKeilmuan(this)">
                        <option value="">-- Pilih Pengajuan Sempro --</option>
                        @foreach ($pengajuanSemproList as $pengajuan)
                            <option value="{{ $pengajuan->id }}" data-bidang="{{ $pengajuan->bidangKeilmuan->name }}"
                                data-bidang-id="{{ $pengajuan->bidang_keilmuan_id }}"
                                {{ old('pengajuan_sempro_id') == $pengajuan->id ? 'selected' : '' }}>{{ $pengajuan->judul }}
                            </option>
                        @endforeach
                    </select>
                    @error('pengajuan_sempro_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Bidang Keilmuan</label>
                    <p id="bidang_keilmuan" class="text-gray-600">
                        {{ old('pengajuan_sempro_id') ? $pengajuanSemproList->find(old('pengajuan_sempro_id'))?->bidangKeilmuan?->name : 'Pilih pengajuan sempro terlebih dahulu' }}
                    </p>
                </div>

                <div class="mb-4">
                    <label for="tanggal" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('tanggal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="waktu" class="block text-gray-700 font-medium mb-2">Waktu</label>
                    <input type="time" id="waktu" name="waktu" value="{{ old('waktu') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('waktu')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="ruang" class="block text-gray-700 font-medium mb-2">Ruang</label>
                    <input type="text" id="ruang" name="ruang" value="{{ old('ruang') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('ruang')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="dosen_penguji_1" class="block text-gray-700 font-medium mb-2">Dosen Penguji 1</label>
                    <div id="jadwal_dosen_1" class="mb-2 hidden">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                                    <th class="border border-gray-300 px-4 py-2">Pukul</th>
                                    <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                                    <th class="border border-gray-300 px-4 py-2">Ruang</th>
                                </tr>
                            </thead>
                            <tbody id="jadwal_dosen_1_body"></tbody>
                        </table>
                    </div>
                    <select id="dosen_penguji_1" name="dosen_penguji_1"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        onchange="loadJadwalDosen(this, 'jadwal_dosen_1', 'jadwal_dosen_1_body')">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" data-bidang-id="{{ $dosen->bidang_keilmuan_id }}"
                                {{ old('dosen_penguji_1') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}
                                ({{ $dosen->bidangKeilmuan->name }})</option>
                        @endforeach
                    </select>
                    @error('dosen_penguji_1')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="dosen_penguji_2" class="block text-gray-700 font-medium mb-2">Dosen Penguji 2</label>
                    <div id="jadwal_dosen_2" class="mb-2 hidden">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                                    <th class="border border-gray-300 px-4 py-2">Pukul</th>
                                    <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                                    <th class="border border-gray-300 px-4 py-2">Ruang</th>
                                </tr>
                            </thead>
                            <tbody id="jadwal_dosen_2_body"></tbody>
                        </table>
                    </div>
                    <select id="dosen_penguji_2" name="dosen_penguji_2"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        onchange="loadJadwalDosen(this, 'jadwal_dosen_2', 'jadwal_dosen_2_body')">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" data-bidang-id="{{ $dosen->bidang_keilmuan_id }}"
                                {{ old('dosen_penguji_2') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}
                                ({{ $dosen->bidangKeilmuan->name }})</option>
                        @endforeach
                    </select>
                    @error('dosen_penguji_2')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="dosen_penguji_3" class="block text-gray-700 font-medium mb-2">Dosen Penguji 3</label>
                    <div id="jadwal_dosen_3" class="mb-2 hidden">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                                    <th class="border border-gray-300 px-4 py-2">Pukul</th>
                                    <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                                    <th class="border border-gray-300 px-4 py-2">Ruang</th>
                                </tr>
                            </thead>
                            <tbody id="jadwal_dosen_3_body"></tbody>
                        </table>
                    </div>
                    <select id="dosen_penguji_3" name="dosen_penguji_3"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        onchange="loadJadwalDosen(this, 'jadwal_dosen_3', 'jadwal_dosen_3_body')">
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" data-bidang-id="{{ $dosen->bidang_keilmuan_id }}"
                                {{ old('dosen_penguji_3') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}
                                ({{ $dosen->bidangKeilmuan->name }})</option>
                        @endforeach
                    </select>
                    @error('dosen_penguji_3')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="dijadwalkan" {{ old('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan
                        </option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateBidangKeilmuan(select) {
            const bidangElement = document.getElementById('bidang_keilmuan');
            const selectedOption = select.options[select.selectedIndex];
            const bidang = selectedOption ? selectedOption.getAttribute('data-bidang') :
                'Pilih pengajuan sempro terlebih dahulu';
            bidangElement.textContent = bidang;

            // Update dosen options based on bidang keilmuan
            const bidangId = selectedOption ? selectedOption.getAttribute('data-bidang-id') : null;
            const selects = [
                document.getElementById('dosen_penguji_1'),
                document.getElementById('dosen_penguji_2'),
                document.getElementById('dosen_penguji_3')
            ];

            selects.forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (option.value === '') return;
                    option.style.display = bidangId && option.getAttribute('data-bidang-id') === bidangId ?
                        'block' : 'none';
                });
            });
        }

        function loadJadwalDosen(select, tableId, tableBodyId) {
            const dosenId = select.value;
            const table = document.getElementById(tableId);
            const tableBody = document.getElementById(tableBodyId);

            if (!dosenId) {
                table.classList.add('hidden');
                tableBody.innerHTML = '';
                return;
            }

            fetch(`/admin/jadwal/dosen/${dosenId}/jadwal`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="4" class="border border-gray-300 px-4 py-2 text-center">Tidak ada jadwal</td></tr>';
                    } else {
                        data.forEach(jadwal => {
                            const row = `
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">${jadwal.hari}</td>
                                    <td class="border border-gray-300 px-4 py-2">${jadwal.pukul}</td>
                                    <td class="border border-gray-300 px-4 py-2">${jadwal.mata_kuliah}</td>
                                    <td class="border border-gray-300 px-4 py-2">${jadwal.ruang}</td>
                                </tr>
                            `;
                            tableBody.innerHTML += row;
                        });
                    }
                    table.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="4" class="border border-gray-300 px-4 py-2 text-center">Gagal memuat jadwal</td></tr>';
                    table.classList.remove('hidden');
                });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateBidangKeilmuan(document.getElementById('pengajuan_sempro_id'));
            ['dosen_penguji_1', 'dosen_penguji_2', 'dosen_penguji_3'].forEach(id => {
                const select = document.getElementById(id);
                if (select.value) {
                    loadJadwalDosen(select, `jadwal_${id.split('_').pop()}`, `jadwal_${id.split('_').pop()}_body`);
                }
            });
        });
    </script>
@endsection