@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-10 px-4">
        <div class="w-full max-w-5xl bg-white rounded-xl shadow-xl overflow-hidden flex flex-col md:flex-row relative">

            <!-- Gradient Background Hijau -->
            <div class="absolute inset-0 bg-gradient-to-br from-white via-green-50 to-green-100 z-0"></div>

            <!-- Kiri: Form Register -->
            <div class="relative z-10 w-full md:w-1/2 p-10 flex flex-col justify-between">

                <!-- Header Logo + Teks -->
                <div class="flex items-center space-x-4 mb-10">
                    <img src="{{ asset('Assets/img/Picture1.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                    <div>
                        <p class="text-sm text-gray-600">Seminar Proposal</p>
                        <p class="text-sm font-semibold text-gray-800">UIN Maulana Malik Ibrahim Malang</p>
                    </div>
                </div>

                <!-- Register Form -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Register</h2>
                    <p class="text-gray-500 mb-6">Please register to create an account</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring focus:ring-green-300">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">No Identitas (NIM/NIP)</label>
                            <input type="text" name="no_identitas" required
                                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring focus:ring-green-300">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">Email</label>
                            <input type="email" name="email" required
                                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring focus:ring-green-300">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">Password</label>
                            <input type="password" name="password" required
                                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring focus:ring-green-300">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring focus:ring-green-300">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm text-gray-700">Role</label>
                            <select name="role" required
                                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring focus:ring-green-300">
                                <option value="">-- Pilih Peran --</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-green-400 hover:bg-green-500 text-white font-medium py-2 rounded-md transition">
                            Register →
                        </button>
                    </form>

                </div>
            </div>

            <!-- Kanan: Ilustrasi + Quote -->
            <div class="relative z-10 w-full md:w-1/2 flex flex-col justify-between items-center px-6 py-10 bg-transparent">

                <!-- Quote -->
                <p class="text-sm italic text-gray-600 mb-4 text-right w-full">
                    <span class="font-semibold">Lorem ipsum dolor sit amet</span>, consectetur adipiscing elit. – <span
                        class="italic">Loreum</span>
                </p>

                <!-- Ilustrasi Karakter -->
                <div class="flex-1 flex justify-center items-end pr-20">
                    <img src="{{ asset('Assets/img/graduation.png') }}" alt="Ilustrasi" class="max-w-xl object-contain">
                </div>

                <!-- Helpdesk -->
                <div class="mt-6 text-xs text-gray-600 w-full text-right">
                    Helpdesk: <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5h2l.4 2M7 3h10l1 4H6.4M16 7v10H8V7m0 0H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3">
                            </path>
                        </svg>
                        <span class="font-semibold">uin@gmail.com</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection