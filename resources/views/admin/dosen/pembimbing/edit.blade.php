@extends('admin.layouts.main')

@section('title', 'Edit Dosen Pembimbing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Edit Dosen Pembimbing</h2>
            <a href="{{ route('admin.dosen.pembimbing.index') }}"
                class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>


        <form action="{{ route('admin.dosen.pembimbing.update', $dosen->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Dosen (Readonly) -->
            <div>
                <label for="nama_dosen" class="block text-sm font-medium text-gray-700 mb-1">Nama Dosen</label>
                <input type="text" id="nama_dosen" value="{{ $dosen->user->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-700" readonly>
            </div>

            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" id="nip" value="{{ $dosen->nip }}" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-700" readonly>
            </div>

            <!-- Kapasitas Maksimum -->
            <div>
                <label for="kapasitas_maksimum" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Maksimum</label>
                <input type="number" id="kapasitas_maksimum" name="kapasitas_maksimum" min="1"
                    value="{{ old('kapasitas_maksimum', $dosen->pembimbing->kapasitas_maksimum) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('kapasitas_maksimum')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div>
                <label for="status_aktif" class="block text-sm font-medium text-gray-700 mb-1">Status Aktif</label>
                <select id="status_aktif" name="status_aktif"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="1" {{ $dosen->pembimbing->status_aktif ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$dosen->pembimbing->status_aktif ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status_aktif')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
