@extends('admin.layouts.main')

@section('title', 'Edit Dosen Penguji')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Dosen Penguji</h2>
    <form action="{{ route('admin.dosen.penguji.update', $dosen->id) }}" method="POST" class="max-w-lg bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $dosen->user->name) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $dosen->user->email) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="nip" class="block text-gray-700 font-medium mb-2">NIP</label>
            <input type="text" id="nip" name="nip" value="{{ old('nip', $dosen->nip) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('nip')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="tempat_lahir" class="block text-gray-700 font-medium mb-2">Tempat Lahir</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $dosen->tempat_lahir) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('tempat_lahir')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $dosen->tanggal_lahir) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('tanggal_lahir')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="asal_kota" class="block text-gray-700 font-medium mb-2">Asal Kota</label>
            <input type="text" id="asal_kota" name="asal_kota" value="{{ old('asal_kota', $dosen->asal_kota) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('asal_kota')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="bidang_keilmuan_id" class="block text-gray-700 font-medium mb-2">Bidang Keilmuan</label>
            <select id="bidang_keilmuan_id" name="bidang_keilmuan_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">-- Pilih Bidang Keilmuan --</option>
                @foreach ($bidangKeilmuan as $bidang)
                    <option value="{{ $bidang->id }}" {{ old('bidang_keilmuan_id', $dosen->bidang_keilmuan_id) == $bidang->id ? 'selected' : '' }}>{{ $bidang->name }}</option>
                @endforeach
            </select>
            @error('bidang_keilmuan_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="pengalaman_jadi_penguji" class="block text-gray-700 font-medium mb-2">Pengalaman Jadi Penguji</label>
            <input type="number" id="pengalaman_jadi_penguji" name="pengalaman_jadi_penguji" value="{{ old('pengalaman_jadi_penguji', $dosen->penguji->pengalaman_jadi_penguji) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            @error('pengalaman_jadi_penguji')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status_aktif" class="block text-gray-700 font-medium mb-2">Status Aktif</label>
            <select id="status_aktif" name="status_aktif" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="1" {{ old('status_aktif', $dosen->penguji->status_aktif) ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status_aktif', !$dosen->penguji->status_aktif) ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status_aktif')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-black rounded-lg hover:bg-teal-700 transition duration-300 ease-in-out">
            <i class="fas fa-save mr-2"></i> Simpan
        </button>
    </form>
</div>
@endsection