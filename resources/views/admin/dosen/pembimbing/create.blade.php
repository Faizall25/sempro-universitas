@extends('admin.layouts.main')

@section('title', 'Tambah Dosen Pembimbing')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Dosen Pembimbing</h2>
    <form action="{{ route('admin.dosen.pembimbing.store') }}" method="POST" class="max-w-lg bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="dosen_id" class="block text-gray-700 font-medium mb-2">Pilih Dosen</label>
            @if ($dosenList->isEmpty())
                <p class="text-red-500 text-sm">Tidak ada dosen yang tersedia untuk dipilih. Silakan tambahkan dosen baru terlebih dahulu.</p>
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
        @if (!$dosenList->isEmpty())
            <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-blue rounded-lg hover:bg-teal-700">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        @endif
    </form>
</div>
@endsection