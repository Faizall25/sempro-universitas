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
                        <h2 class="text-2xl font-bold">Selamat Datang dosen!</h2>
                        <p class="mt-2">Ikuti update terbaru dari Universitas Islam Negeri Maulana Malik Ibrahim Malang.</p>
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

        <!-- Card Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card 1: Profil dosen -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h3 style="color: #006066; font-weight: bold; font-size: 1.5rem; margin-bottom: 1.5rem;">
                    Jadwal Mata Kuliah
                </h3>

                @if($jadwal->count())
                    <div style="overflow-x:auto;">
                        <table
                            style="min-width: 100%; border-collapse: collapse; border: 2px solid #006066; border-radius: 8px; overflow: hidden;">
                            <thead style="background-color: #006066; color: white;">
                                <tr>
                                    <th
                                        style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Hari</th>
                                    <th
                                        style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Pukul</th>
                                    <th
                                        style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Mata Kuliah</th>
                                    <th
                                        style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Dosen</th>
                                    <th
                                        style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Kelas</th>
                                    <th
                                        style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Ruang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwal as $item)
                                    <tr style="border-top: 1px solid #ddd; transition: background-color 0.3s ease, color 0.3s ease; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='rgba(0, 96, 102, 0.15)'; this.style.color='inherit';"
                                        onmouseout="this.style.backgroundColor=''; this.style.color='';">
                                        <td style="padding: 12px 16px; font-size: 0.875rem;">{{ $item->hari }}</td>
                                        <td style="padding: 12px 16px; font-size: 0.875rem;">
                                            {{ \Carbon\Carbon::parse($item->pukul)->format('H:i') }}</td>
                                        <td style="padding: 12px 16px; font-size: 0.875rem;">{{ $item->mata_kuliah }}</td>
                                        <td style="padding: 12px 16px; font-size: 0.875rem;">
                                            {{ $item->dosen->user->name ?? 'Nama tidak tersedia' }}</td>
                                        <td style="padding: 12px 16px; font-size: 0.875rem;">{{ $item->kelas }}</td>
                                        <td style="padding: 12px 16px; font-size: 0.875rem;">{{ $item->ruang }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                @else
                    <p class="text-gray-600">Belum ada jadwal mengajar.</p>
                @endif

                <a href="{{ route('dosen.jadwal_perkuliahan.index') }}"
                    class="mt-4 inline-block px-4 py-2 bg-teal-600 rounded-lg hover:bg-teal-700 transition duration-300"
                    style="color: white; background-color:#006066;">Lihat Detail</a>
            </div>

            <!-- Card 2: Jadwal Kuliah Hari Ini -->
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <h3 style="color: #006066; font-weight: bold; font-size: 1.5rem; margin-bottom: 1.5rem;">
                    Daftar Pengajuan Seminar Proposal Mahasiswa
                </h3>

                @if($pengajuan->isEmpty())
                    <div style="color: #006066;" class="text-center italic">
                        Belum ada pengajuan seminar proposal.
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl" style="border: 1px solid #006066;">
                        <table class="min-w-full bg-white" style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">No</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">NIM</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">Nama Mahasiswa</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">Judul</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">Dosen Pembimbing</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan as $index => $item)
                                    <tr style="border-bottom: 1px solid #e0e0e0;" class="hover:bg-gray-50 transition duration-200">
                                        <td style="padding: 12px;">{{ $index + 1 }}</td>
                                        <td style="padding: 12px;">{{ $item->mahasiswa->nim ?? '-' }}</td>
                                        <td style="padding: 12px;">{{ $item->mahasiswa->user->name ?? '-' }}</td>
                                        <td style="padding: 12px;">{{ $item->judul }}</td>
                                        <td style="padding: 12px;">{{ $item->dosenPembimbing->user->name ?? '-' }}</td>
                                        <td style="padding: 12px;">
                                            <span class="px-3 py-1 rounded-full text-xs 
                                                {{ 
                                                    $item->status == 'diterima' ? 'bg-green-100 text-green-700' :
                                                    ($item->status == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') 
                                                }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-6 text-right">
                    <a href="{{ route('dosen.profile') }}"
                    class="inline-block px-5 py-2 rounded-xl hover:bg-[#004f4f] transition duration-300 shadow"
                    style="color: ghostwhite; background: #006066;">
                        Lihat Detail
                    </a>
                </div>
            </div>

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