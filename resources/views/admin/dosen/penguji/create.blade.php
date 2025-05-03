@extends('admin.layouts.main')

@section('title', 'Tambah Dosen Penguji')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Dosen Penguji</h2>
    <form action="{{ route('admin.dosen.penguji.store') }}" method="POST" class="max-w-lg bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="dosen_id" class="block text-gray-700 font-medium mb-2">Pilih Dosen</label>
            @if ($dosenList->isEmpty())
                <p class="text-red-500 text-sm font-medium bg-red-50 p-3 rounded-lg">Tidak ada dosen yang tersedia untuk ditambahkan sebagai penguji. Silakan tambahkan dosen baru terlebih dahulu.</p>
            @else
                <select id="dosen_id" name="dosen_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->user->name }} (NIP: {{ $dosen->nip }})</option>
                    @endforeach
                </select>
                @error('dosen_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            @endif
        </div>
        <div class="mb-4">
            <label for="bidang_keilmuan_id" class="block text-gray-700 font-medium mb-2">Bidang Keilmuan</label>
            @if ($bidangKeilmuan->isEmpty())
                <p class="text-red-500 text-sm font-medium bg-red-50 p-3 rounded-lg">Tidak ada bidang keilmuan yang tersedia. Silakan tambahkan bidang keilmuan terlebih dahulu.</p>
            @else
                <select id="bidang_keilmuan_id" name="bidang_keilmuan_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Bidang Keilmuan --</option>
                    @foreach ($bidangKeilmuan as $bidang)
                        <option value="{{ $bidang->id }}">{{ $bidang->name }}</option>
                    @endforeach
                </select>
                @error('bidang_keilmuan_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            @endif
        </div>
        @if (!$dosenList->isEmpty() && !$bidangKeilmuan->isEmpty())
            <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300 ease-in-out">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        @endif
    </form>
</div>
@endsection