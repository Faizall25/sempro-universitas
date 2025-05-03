@extends('mahasiswa.layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 md:flex md:space-x-8">
            <!-- Foto Profil -->
            <div class="flex justify-center md:w-1/3 mb-6 md:mb-0">
                <img src="/images/admin.jpg" alt="Foto Profil"
                     class="w-40 h-50 thumbnail-full object-cover border-4 border-teal-400 hover:scale-105 transition-transform duration-300 shadow-md">
            </div>

            <!-- Detail Profil -->
            <div class="md:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                <x-profile-field label="Angkatan" :value="$mahasiswa->tahun_masuk" />
                <x-profile-field label="NIM" :value="$mahasiswa->nim" />
                <x-profile-field label="Nama Mahasiswa" :value="$mahasiswa->user->name" />
                <x-profile-field label="Tempat Lahir" :value="$mahasiswa->tempat_lahir" />
                <x-profile-field label="Tanggal Lahir" :value="$mahasiswa->tanggal_lahir->format('d M Y')" />
                <x-profile-field label="Email Pribadi" :value="$mahasiswa->user->email" />
                <x-profile-field label="Asal Kota" :value="$mahasiswa->asal_kota" />
                {{-- <x-profile-field label="Nama Orang Tua" value="Tidak Tersedia" /> --}}
                {{-- <x-profile-field label="Alamat Orang Tua" value="Tidak Tersedia" /> --}}
                {{-- <x-profile-field label="Propinsi Orang Tua" :value="$mahasiswa->asal_kota" /> --}}
                {{-- <x-profile-field label="Kota Orang Tua" :value="$mahasiswa->asal_kota" /> --}}
            </div>
        </div>

        <div class="flex justify-end px-6 pb-6">
            <button onclick="openEditModal()"
                    class="bg-blue-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-blue-700 transition ease-in-out duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                ✏️ Ubah Profil
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="editModal"
     class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden transition-opacity duration-300 ease-out">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 transform scale-95 opacity-0 transition-all duration-300 ease-out"
         id="editModalContent">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Edit Profil</h3>
        <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <x-input-field name="name" label="Nama" :value="$mahasiswa->user->name" required />
            <x-input-field name="email" label="Email (@student.com)" type="email" :value="$mahasiswa->user->email" required />
            <x-input-field name="password" label="Password Baru" type="password" />
            <x-input-field name="password_confirmation" label="Konfirmasi Password" type="password" />

            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-full hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal() {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('editModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('editModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
