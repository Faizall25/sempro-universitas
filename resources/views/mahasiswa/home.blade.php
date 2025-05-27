@extends('mahasiswa.layouts.main')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Banner Section -->
        <div class="relative w-full mb-6 overflow-hidden rounded-lg shadow-lg" id="bannerCarousel">
            <div class="banner-slide">
                <img src="/assets/img/slide1.png" alt="Banner 1" class="w-full h-auto object-cover">
                <div
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
                    <div>
                        <h2 class="text-2xl font-bold">Selamat Datang Mahasiswa!</h2>
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
            <!-- Card 1: Profil Mahasiswa -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h3 style="color: #006066; font-weight: bold; font-size: 1.5rem; margin-bottom: 1rem;">
                    Grafik IPK Mahasiswa
                </h3>

                <p class="text-gray-700 mb-1">
                    <strong>Nama:</strong> {{ $mahasiswa->user->name }}
                </p>
                <p class="text-gray-700 mb-1">
                    <strong>NIM:</strong> {{ $mahasiswa->nim }}
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>IPK:</strong> <span id="ipk-value">-</span>
                </p>

                <div style="width: 100%; height: auto;">
                    <canvas id="ipkChart"></canvas>
                </div>
            </div>

            <!-- Card 2: Jadwal Kuliah Hari Ini -->
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <h3 style="color: #006066; font-weight: bold; font-size: 1.5rem; margin-bottom: 1.5rem;">
                    Pengajuan Seminar Proposal Anda
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
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">
                                        No</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">
                                        Judul</th>
                                    <th style="color: #006066; padding: 12px; text-align: left; border-bottom: 1px solid #ccc;">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan as $index => $item)
                                                <tr style="border-bottom: 1px solid #e0e0e0;" class="hover:bg-gray-50 transition duration-200">
                                                    <td style="padding: 12px; color: #333;">{{ $index + 1 }}</td>
                                                    <td style="padding: 12px; color: #333;">{{ $item->judul }}</td>
                                                    <td style="padding: 12px;">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs {{$item->status == 'diterima' ? 'bg-green-100 text-green-700' :
                                    ($item->status == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
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
                    <a href="{{ route('mahasiswa.pengajuan_sempro.index') }}"
                        class="inline-block px-5 py-2 rounded-xl hover:bg-[#004f4f] transition duration-300 shadow"
                        style="color: ghostwhite; background: #006066;">
                        Lihat Detail Pengajuan
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    const ctx = document.getElementById('ipkChart').getContext('2d');

    // Data dummy IPS (per semester)
    const ips = [3.65, 3.72, 3.81, 3.90, 3.75, 3.88];

    // Hitung IPK
    const ipk = (ips.reduce((acc, val) => acc + val, 0) / ips.length).toFixed(2);
    document.getElementById('ipk-value').innerText = ipk;

    // Chart
    const ipkChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6'],
            datasets: [{
                label: 'IPS',
                data: ips,
                borderColor: '#006066',
                backgroundColor: 'rgba(0, 96, 102, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#006066'
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                datalabels: {
                    color: '#000',
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value) {
                        return value.toFixed(2);
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: 3.0,
                    suggestedMax: 4.0
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
@endsection