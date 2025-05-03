@extends('dosen.layouts.main')

@section('content')
<div class="container mx-auto p-6">
    <!-- Banner Section -->
    <div class="relative w-full mb-6 overflow-hidden rounded-lg shadow-lg" id="bannerCarousel">
        <div class="banner-slide">
            <img src="/assets/img/slide1.png" alt="Banner 1" class="w-full h-auto object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
                <div>
                    <h2 class="text-2xl font-bold">Selamat Datang dosen!</h2>
                    <p class="mt-2">Ikuti update terbaru dari Universitas Islam Negeri Maulana Malik Ibrahim Malang.</p>
                </div>
            </div>
        </div>
        <div class="banner-slide hidden">
            <img src="/assets/img/slide2.png" alt="Banner 2" class="w-full h-auto object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
                <div>
                    <h2 class="text-2xl font-bold">Pendaftaran Seminar</h2>
                    <p class="mt-2">Daftar sekarang untuk seminar akhir semester.</p>
                </div>
            </div>
        </div>
        <div class="banner-slide hidden">
            <img src="/assets/img/slide3.png" alt="Banner 3" class="w-full h-auto object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-center p-4">
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
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Profil dosen</h3>
            <p class="text-gray-600">Lihat detail informasi akademik Anda, termasuk IPK, status studi, dan dosen wali.</p>
            <a href="{{ route('dosen.profile') }}" class="mt-4 inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300">Lihat Profil</a>
        </div>

        <!-- Card 2: Jadwal Kuliah Hari Ini -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Jadwal Kuliah Hari Ini</h3>
            <p class="text-gray-600">Tilik jadwal kuliah Anda hari ini dan eksplorasi pengelaman baru di kampus.</p>
            <a href="{{ route('dosen.profile') }}" class="mt-4 inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300">Lihat Jadwal</a>
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