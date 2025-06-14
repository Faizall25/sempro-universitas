@extends('dosen.layouts.main')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Banner Section -->
        <div class="relative w-full mb-6 overflow-hidden rounded-lg shadow-lg" id="bannerCarousel">
            <div class="banner-slide">
                <img src="/assets/img/slide1.png" alt="Banner 1" class="w-full h-auto object-cover">
                <div
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
                    <div>
                        <h2 class="text-2xl font-bold">Selamat Datang Dosen!</h2>
                        <p class="mt-2">Ikuti update terbaru dari Universitas Islam Negeri Maulana Malik Ibrahim Malang.
                        </p>
                    </div>
                </div>
            </div>
            <div class="banner-slide hidden">
                <img src="/assets/img/slide2.png" alt="Banner 2" class="w-full h-auto object-cover">
                <div
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
                    <div>
                        <h2 class="text-2xl font-bold">Pendaftaran Seminar</h2>
                        <p class="mt-2">Daftar sekarang untuk seminar akhir semester.</p>
                    </div>
                </div>
            </div>
            <div class="banner-slide hidden">
                <img src="/assets/img/slide3.png" alt="Banner 3" class="w-full h-auto object-cover">
                <div
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
                    <div>
                        <h2 class="text-2xl font-bold">Beasiswa 2025</h2>
                        <p class="mt-2">Info lengkap tentang beasiswa terbaru.</p>
                    </div>
                </div>
            </div>
            <!-- Navigation Dots -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <span class="dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer" data-slide="0"></span>
                <span class="dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer" data-slide="1"></span>
                <span class="dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer" data-slide="2"></span>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Statistik Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-gray-600">Pengajuan Pending</h4>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['pending_pengajuan'] }}</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-gray-600">Jadwal Sempro Minggu Ini</h4>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['jadwal_sempro_week'] }}</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-gray-600">Mata Kuliah Minggu Ini</h4>
                    <p class="text-2xl font-semibold text-gray-800">{{ $stats['mata_kuliah_week'] }}</p>
                </div>
            </div>
        </div>

        <!-- Jadwal Mata Kuliah Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Jadwal Mata Kuliah Hari Ini ({{ $today }})</h3>
                <a href="{{ route('dosen.profile') }}"
                    class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300">Lihat
                    Semua Jadwal</a>
            </div>
            @if ($jadwalMataKuliah->isEmpty())
                <p class="text-gray-500 italic">Tidak ada jadwal mata kuliah hari ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left">Waktu</th>
                                <th class="py-2 px-4 text-left">Mata Kuliah</th>
                                <th class="py-2 px-4 text-left">Kode</th>
                                <th class="py-2 px-4 text-left">Kelas</th>
                                <th class="py-2 px-4 text-left">Ruang</th>
                                <th class="py-2 px-4 text-left">SKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalMataKuliah as $jadwal)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $jadwal->pukul->format('H:i') }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->mata_kuliah }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->kode }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->kelas }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->ruang }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->sks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Pengajuan Sempro Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Pengajuan Seminar Proposal</h3>
                <form method="GET" action="{{ route('dosen.home') }}" class="flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul atau nama mahasiswa..."
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="submit"
                        class="ml-2 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Cari</button>
                </form>
            </div>
            @if ($pengajuanSempro->isEmpty())
                <p class="text-gray-500 italic">Belum ada pengajuan seminar proposal yang Anda bimbing.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left">No</th>
                                <th class="py-2 px-4 text-left">Judul</th>
                                <th class="py-2 px-4 text-left">Nama Mahasiswa</th>
                                <th class="py-2 px-4 text-left">Bidang Keilmuan</th>
                                <th class="py-2 px-4 text-left">Status</th>
                                <th class="py-2 px-4 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuanSempro as $index => $pengajuan)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $index + $pengajuanSempro->firstItem() }}</td>
                                    <td class="py-2 px-4">
                                        {{ $pengajuan->judul }}
                                        @if ($pengajuan->created_at->diffInHours(now()) < 24)
                                            <span
                                                class="ml-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">Baru</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">{{ $pengajuan->mahasiswa->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">{{ $pengajuan->bidangKeilmuan->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">
                                        <span
                                            class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ $pengajuan->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : ($pengajuan->status == 'diterima' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 flex space-x-2">
                                        @if ($pengajuan->status == 'pending')
                                            <form action="{{ route('dosen.pengajuan-sempro.approve', $pengajuan->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300"
                                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('dosen.pengajuan-sempro.reject', $pengajuan->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300"
                                                    onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Tidak ada aksi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $pengajuanSempro->links() }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Jadwal Sempro Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Jadwal Seminar Proposal (Dijadwalkan)</h3>
            @if ($jadwalSempro->isEmpty())
                <p class="text-gray-500 italic">Tidak ada jadwal seminar proposal yang dijadwalkan.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left">Tanggal</th>
                                <th class="py-2 px-4 text-left">Waktu</th>
                                <th class="py-2 px-4 text-left">Ruang</th>
                                <th class="py-2 px-4 text-left">Judul</th>
                                <th class="py-2 px-4 text-left">Mahasiswa</th>
                                <th class="py-2 px-4 text-left">Peran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalSempro as $jadwal)
                                @php
                                    $roles = [];
                                    if (
                                        $jadwal->pengajuanSempro &&
                                        $jadwal->pengajuanSempro->dosen_pembimbing_id == $dosen->id
                                    ) {
                                        $roles[] = 'Pembimbing';
                                    }
                                    if (
                                        in_array($dosen->id, [
                                            $jadwal->dosen_penguji_1,
                                            $jadwal->dosen_penguji_2,
                                            $jadwal->dosen_penguji_3,
                                        ])
                                    ) {
                                        $roles[] = 'Penguji';
                                    }
                                    $roleText = implode(' & ', $roles);
                                @endphp
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">{{ $jadwal->tanggal->format('d M Y') }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->waktu->format('H:i') }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->ruang }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->pengajuanSempro->judul ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">{{ $jadwal->pengajuanSempro->mahasiswa->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4">
                                        <span
                                            class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ str_contains($roleText, 'Pembimbing') ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                            {{ $roleText ?: 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        const bannerSlides = document.querySelectorAll('.banner-slide');
        const dots = document.querySelectorAll('.dot');
        let currentSlide = 0;
        const slideInterval = 5000; // 5 detik

        function showSlide(index) {
            bannerSlides.forEach((slide, i) => {
                slide.classList.toggle('hidden', i !== index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-opacity-50', i !== index);
                dot.classList.toggle('bg-opacity-100', i === index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % bannerSlides.length;
            showSlide(currentSlide);
        }

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentSlide = parseInt(dot.getAttribute('data-slide'));
                showSlide(currentSlide);
                clearInterval(slideTimer);
                slideTimer = setInterval(nextSlide, slideInterval);
            });
        });

        let slideTimer = setInterval(nextSlide, slideInterval);
        showSlide(currentSlide);
    </script>
@endsection
