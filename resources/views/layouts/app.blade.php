<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title') - Sempro UIN Malang</title>
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #wrapper {
            display: flex;
            flex: 1;
        }
        #sidebar-wrapper {
            position: fixed;
            top: 56px; /* Sesuaikan dengan tinggi navbar */
            left: 0;
            width: 250px;
            height: calc(100vh - 56px - 40px); /* Kurangi tinggi navbar dan footer */
            background: #f8f9fa;
            transition: all 0.3s;
            z-index: 999;
        }
        #content-wrapper {
            margin-left: 250px;
            margin-top: 56px; /* Sesuaikan dengan tinggi navbar */
            margin-bottom: 40px; /* Sesuaikan dengan tinggi footer */
            flex: 1;
            overflow-y: auto;
            height: calc(100vh - 56px - 40px); /* Pastikan content bisa discroll */
            transition: margin-left 0.3s;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #fff;
            padding: 10px 0;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .sidebar-heading {
            color: #6c757d;
            font-size: 0.875rem;
            text-transform: uppercase;
            padding: 10px 15px;
        }
        .nav-link {
            color: #6c757d !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link:hover, .nav-link.active {
            color: #17a2b8 !important;
            background: #e9ecef;
        }
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }
            #content-wrapper {
                margin-left: 0;
            }
            #sidebar-wrapper.toggled {
                margin-left: 0;
            }
        }
    </style>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('layouts.partials.navbar')

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.partials.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap SB Admin 2 Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>