@extends('admin.layouts.main')

@section('title', 'Tambah Jadwal Sempro')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Tambah Jadwal Sempro</h2>
            <a href="{{ route('admin.jadwal.sempro.index') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.jadwal.sempro.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="pengajuan_sempro_id" class="block text-gray-700 font-medium mb-2">Pengajuan Sempro</label>
                <select id="pengajuan_sempro_id" name="pengajuan_sempro_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Pengajuan Sempro --</option>
                    @foreach ($pengajuanSemproList as $pengajuan)
                        <option value="{{ $pengajuan->id }}" {{ old('pengajuan_sempro_id') == $pengajuan->id ? 'selected' : '' }}>{{ $pengajuan->judul }}</option>
                    @endforeach
                </select>
                @error('pengajuan_sempro_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('tanggal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="waktu" class="block text-gray-700 font-medium mb-2">Waktu</label>
                <input type="time" id="waktu" name="waktu" value="{{ old('waktu') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('waktu')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="ruang" class="block text-gray-700 font-medium mb-2">Ruang</label>
                <input type="text" id="ruang" name="ruang" value="{{ old('ruang') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('ruang')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="dosen_penguji_1" class="block text-gray-700 font-medium mb-2">Dosen Penguji 1</label>
                <select id="dosen_penguji_1" name="dosen_penguji_1" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_penguji_1') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}</option>
                    @endforeach
                </select>
                @error('dosen_penguji_1')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="dosen_penguji_2" class="block text-gray-700 font-medium mb-2">Dosen Penguji 2</label>
                <select id="dosen_penguji_2" name="dosen_penguji_2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_penguji_2') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}</option>
                    @endforeach
                </select>
                @error('dosen_penguji_2')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="dosen_penguji_3" class="block text-gray-700 font-medium mb-2">Dosen Penguji 3</label>
                <select id="dosen_penguji_3" name="dosen_penguji_3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_penguji_3') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}</option>
                    @endforeach
                </select>
                @error('dosen_penguji_3')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                <select id="status" name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="dijadwalkan" {{ old('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection