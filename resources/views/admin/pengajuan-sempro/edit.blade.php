@extends('admin.layouts.main')

@section('title', 'Edit Pengajuan Sempro')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Edit Pengajuan Sempro</h2>
                <a href="{{ route('admin.pengajuan-sempro.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.pengajuan-sempro.update', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="mahasiswa_id" class="block text-gray-700 font-medium mb-2">Mahasiswa</label>
                    <select id="mahasiswa_id" name="mahasiswa_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}" {{ $pengajuan->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->user->name }} (NIM: {{ $mhs->nim }})
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="judul" class="block text-gray-700 font-medium mb-2">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $pengajuan->judul) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('judul')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="abstrak" class="block text-gray-700 font-medium mb-2">Abstrak</label>
                    <textarea id="abstrak" name="abstrak"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('abstrak', $pengajuan->abstrak) }}</textarea>
                    @error('abstrak')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="jurusan" class="block text-gray-700 font-medium mb-2">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan', $pengajuan->jurusan) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('jurusan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="fakultas" class="block text-gray-700 font-medium mb-2">Fakultas</label>
                    <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas', $pengajuan->fakultas) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('fakultas')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bidang_keilmuan_id" class="block text-gray-700 font-medium mb-2">Bidang Keilmuan</label>
                    <select id="bidang_keilmuan_id" name="bidang_keilmuan_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Bidang Keilmuan --</option>
                        @foreach ($bidangKeilmuan as $bidang)
                            <option value="{{ $bidang->id }}" {{ $pengajuan->bidang_keilmuan_id == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('bidang_keilmuan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="dosen_pembimbing_id" class="block text-gray-700 font-medium mb-2">Dosen Pembimbing</label>
                    <select id="dosen_pembimbing_id" name="dosen_pembimbing_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Dosen Pembimbing --</option>
                        @foreach ($dosen as $dsn)
                            <option value="{{ $dsn->id }}" {{ $pengajuan->dosen_pembimbing_id == $dsn->id ? 'selected' : '' }}>
                                {{ $dsn->user->name }} (KK: {{ $dsn->bidangKeilmuan->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_pembimbing_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
@endsection