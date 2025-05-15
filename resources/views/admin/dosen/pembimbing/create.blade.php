@extends('admin.layouts.main')

@section('title', 'Tambah Dosen Pembimbing')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Tambah Dosen Pembimbing</h2>
                <a href="{{ route('admin.dosen.pembimbing.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.dosen.pembimbing.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="dosen_id" class="block text-gray-700 font-medium mb-2">Pilih Dosen</label>
                    @if ($dosenList->isEmpty() || $dosenList->every(fn($dosen) => $dosen->pembimbing))
                        <p class="text-red-500 text-sm">Tidak ada dosen yang tersedia untuk dipilih. Silakan tambahkan dosen
                            baru terlebih dahulu.</p>
                    @else
                        <select id="dosen_id" name="dosen_id"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($dosenList as $dosen)
                                @if (!$dosen->pembimbing)
                                    <option value="{{ $dosen->id }}">
                                        {{ $dosen->user->name }} (NIP: {{ $dosen->nip }})
                                        {{ $dosen->bidangKeilmuan->name ?? 'Tidak ada bidang keilmuan' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('dosen_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="mb-4">
                    <label for="kapasitas_maksimum" class="block text-gray-700 font-medium mb-2">Kapasitas Maksimum</label>
                    <input type="number" id="kapasitas_maksimum" name="kapasitas_maksimum"
                        value="{{ old('kapasitas_maksimum', 5) }}" placeholder="5"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        min="1">
                    @error('kapasitas_maksimum')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @if (!$dosenList->isEmpty() && $dosenList->some(fn($dosen) => !$dosen->pembimbing))
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
