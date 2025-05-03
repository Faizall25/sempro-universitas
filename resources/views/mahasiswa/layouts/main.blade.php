<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1000;
            background: transparent;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            position: fixed;
            top: 0px;
            left: 0;
            width: 250px;
            height: calc(110vh - 60px - 40px);
            background: #f8f9fa;
            z-index: 999;
            transition: transform 0.3s ease;
        }
        .content-wrapper {
            margin-left: 250px;
            margin-top: 60px;
            margin-bottom: 40px;
            height: calc(100vh - 60px - 40px);
            overflow-y: auto;
            padding: 20px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .content-expanded {
            margin-left: 0;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }
            .content-wrapper {
                margin-left: 0;
            }
            .sidebar-hidden {
                transform: translateX(0);
            }
            .content-expanded {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <div x-data="{ sidebarOpen: false }" class="relative">
        <!-- Navbar -->
        <div class="navbar">
            @include('mahasiswa.layouts.header')
        </div>

        <!-- Sidebar -->
        <div class="sidebar" :class="{ 'sidebar-hidden': !sidebarOpen }">
            @include('mahasiswa.layouts.sidebar')
        </div>

        <!-- Content -->
        <main class="content-wrapper" :class="{ 'content-expanded': sidebarOpen }">
            @yield('content')
            <!-- Footer -->
            <div class="footer">
                @include('mahasiswa.layouts.footer')
            </div>
        </main>
    </div>

    @stack('scripts')
        <script>
        // Pastikan CSRF token tersedia untuk fetch
        if (!document.querySelector('meta[name="csrf-token"]')) {
            console.error('CSRF token not found in meta tag');
        }
</body>
</html>