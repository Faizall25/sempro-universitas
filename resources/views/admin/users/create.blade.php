@extends('admin.layouts.main')

@section('title', 'Tambah User')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Tambah User</h2>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200 mb-6">
                <button id="tab-mahasiswa"
                    class="px-4 py-2 text-gray-600 font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600 focus:outline-none tab-button active"
                    data-tab="mahasiswa">Mahasiswa</button>
                <button id="tab-dosen"
                    class="px-4 py-2 text-gray-600 font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600 focus:outline-none tab-button"
                    data-tab="dosen">Dosen</button>
            </div>

            <!-- Mahasiswa Form -->
            <form id="mahasiswa-form" action="{{ route('admin.users.store') }}" method="POST" class="tab-content">
                @csrf
                <input type="hidden" name="role" value="mahasiswa">
                <div class="mb-4">
                    <label for="mahasiswa-name" class="block text-gray-700 font-medium mb-2">Nama</label>
                    <input type="text" id="mahasiswa-name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-nim" class="block text-gray-700 font-medium mb-2">NIM</label>
                    <input type="text" id="mahasiswa-nim" name="nim" value="{{ old('nim') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nim')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-tempat_lahir" class="block text-gray-700 font-medium mb-2">Tempat Lahir</label>
                    <input type="text" id="mahasiswa-tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tempat_lahir')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                    <input type="date" id="mahasiswa-tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal_lahir')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-asal_kota" class="block text-gray-700 font-medium mb-2">Asal Kota</label>
                    <input type="text" id="mahasiswa-asal_kota" name="asal_kota" value="{{ old('asal_kota') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('asal_kota')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-program_studi" class="block text-gray-700 font-medium mb-2">Program Studi</label>
                    <input type="text" id="mahasiswa-program_studi" name="program_studi"
                        value="{{ old('program_studi') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('program_studi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-fakultas" class="block text-gray-700 font-medium mb-2">Fakultas</label>
                    <input type="text" id="mahasiswa-fakultas" name="fakultas" value="{{ old('fakultas') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('fakultas')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-tahun_masuk" class="block text-gray-700 font-medium mb-2">Tahun Masuk</label>
                    <input type="number" id="mahasiswa-tahun_masuk" name="tahun_masuk" value="{{ old('tahun_masuk') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tahun_masuk')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="mahasiswa-email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="mahasiswa-password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="mahasiswa-password" name="password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
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

            <!-- Dosen Form -->
            <form id="dosen-form" action="{{ route('admin.users.store') }}" method="POST" class="tab-content hidden">
                @csrf
                <input type="hidden" name="role" value="dosen">
                <div class="mb-4">
                    <label for="dosen-name" class="block text-gray-700 font-medium mb-2">Nama</label>
                    <input type="text" id="dosen-name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-nip" class="block text-gray-700 font-medium mb-2">NIP</label>
                    <input type="text" id="dosen-nip" name="nip" value="{{ old('nip') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nip')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-tempat_lahir" class="block text-gray-700 font-medium mb-2">Tempat Lahir</label>
                    <input type="text" id="dosen-tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tempat_lahir')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                    <input type="date" id="dosen-tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal_lahir')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-asal_kota" class="block text-gray-700 font-medium mb-2">Asal Kota</label>
                    <input type="text" id="dosen-asal_kota" name="asal_kota" value="{{ old('asal_kota') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('asal_kota')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-bidang_keilmuan_id" class="block text-gray-700 font-medium mb-2">Bidang
                        Keilmuan</label>
                    <select id="dosen-bidang_keilmuan_id" name="bidang_keilmuan_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Bidang Keilmuan --</option>
                        @foreach ($bidangKeilmuan as $bidang)
                            <option value="{{ $bidang->id }}"
                                {{ old('bidang_keilmuan_id') == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('bidang_keilmuan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="dosen-email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dosen-password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="dosen-password" name="password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
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

    @push('scripts')
        <script>
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    document.querySelectorAll('.tab-button').forEach(btn => {
                        btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                        btn.classList.add('text-gray-600', 'border-transparent');
                    });

                    // Add active class to clicked button
                    button.classList.add('active', 'text-blue-600', 'border-blue-600');
                    button.classList.remove('text-gray-600', 'border-transparent');

                    // Hide all forms
                    document.querySelectorAll('.tab-content').forEach(form => {
                        form.classList.add('hidden');
                    });

                    // Show the selected form
                    document.getElementById(`${button.dataset.tab}-form`).classList.remove('hidden');
                });
            });
        </script>
    @endpush
@endsection
