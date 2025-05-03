@extends('admin.layouts.main')

@section('title', 'Tambah Jadwal Mata Kuliah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Tambah Jadwal Mata Kuliah</h2>
            <a href="{{ route('admin.jadwal.mata-kuliah.index') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.jadwal.mata-kuliah.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="hari" class="block text-gray-700 font-medium mb-2">Hari</label>
                <select id="hari" name="hari" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Hari --</option>
                    <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                </select>
                @error('hari')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pukul" class="block text-gray-700 font-medium mb-2">Pukul</label>
                <input type="time" id="pukul" name="pukul" value="{{ old('pukul') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('pukul')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kelas" class="block text-gray-700 font-medium mb-2">Kelas</label>
                <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('kelas')
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
                <label for="kode" class="block text-gray-700 font-medium mb-2">Kode Mata Kuliah</label>
                <input type="text" id="kode" name="kode" value="{{ old('kode') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('kode')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="mata_kuliah" class="block text-gray-700 font-medium mb-2">Mata Kuliah</label>
                <input type="text" id="mata_kuliah" name="mata_kuliah" value="{{ old('mata_kuliah') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('mata_kuliah')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sks" class="block text-gray-700 font-medium mb-2">SKS</label>
                <input type="number" id="sks" name="sks" value="{{ old('sks') }}" min="1" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('sks')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="dosen_id" class="block text-gray-700 font-medium mb-2">Dosen</label>
                <select id="dosen_id" name="dosen_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->user->name }}</option>
                    @endforeach
                </select>
                @error('dosen_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="asisten_dosen" class="block text-gray-700 font-medium mb-2">Asisten Dosen (Opsional)</label>
                <input type="text" id="asisten_dosen" name="asisten_dosen" value="{{ old('asisten_dosen') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('asisten_dosen')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="mk_jurusan" class="block text-gray-700 font-medium mb-2">Jurusan Mata Kuliah</label>
                <input type="text" id="mk_jurusan" name="mk_jurusan" value="{{ old('mk_jurusan') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('mk_jurusan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-medium mb-2">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('keterangan') }}</textarea>
                @error('keterangan')
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