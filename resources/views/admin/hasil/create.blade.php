@extends('admin.layouts.main')

@section('title', 'Tambah Hasil Sempro')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Tambah Hasil Sempro</h2>
                <a href="{{ route('admin.hasil.sempro.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.hasil.sempro.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="jadwal_sempro_id" class="block text-gray-700 font-medium mb-2">Jadwal Sempro</label>
                    <select id="jadwal_sempro_id" name="jadwal_sempro_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Jadwal Sempro --</option>
                        @foreach ($jadwalSemproList as $jadwal)
                            <option value="{{ $jadwal->id }}"
                                {{ old('jadwal_sempro_id') == $jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->pengajuanSempro->judul ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                    @error('jadwal_sempro_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nilai_peng1" class="block text-gray-700 font-medium mb-2">Nilai Penguji 1</label>
                    <input type="number" id="nilai_peng1" name="nilai_peng1" step="0.01" min="0" max="100"
                        value="{{ old('nilai_peng1') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('nilai_peng1')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nilai_peng2" class="block text-gray-700 font-medium mb-2">Nilai Penguji 2</label>
                    <input type="number" id="nilai_peng2" name="nilai_peng2" step="0.01" min="0" max="100"
                        value="{{ old('nilai_peng2') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('nilai_peng2')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nilai_peng3" class="block text-gray-700 font-medium mb-2">Nilai Penguji 3</label>
                    <input type="number" id="nilai_peng3" name="nilai_peng3" step="0.01" min="0" max="100"
                        value="{{ old('nilai_peng3') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('nilai_peng3')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="lolos_tanpa_revisi" {{ old('status') == 'lolos_tanpa_revisi' ? 'selected' : '' }}>
                            Lolos Tanpa Revisi</option>
                        <option value="revisi_minor" {{ old('status') == 'revisi_minor' ? 'selected' : '' }}>Revisi Minor
                        </option>
                        <option value="revisi_mayor" {{ old('status') == 'revisi_mayor' ? 'selected' : '' }}>Revisi Mayor
                        </option>
                        <option value="tidak_lolos" {{ old('status') == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos
                        </option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="revisi_file" class="block text-gray-700 font-medium mb-2">File Revisi (PDF, maks
                        5MB)</label>
                    <input type="file" id="revisi_file" name="revisi_file" accept=".pdf"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('revisi_file')
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
@endsection
