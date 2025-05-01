<div id="sidebar-wrapper">
    <ul class="navbar-nav sidebar accordion" id="accordionSidebar">
        <!-- Sidebar Heading -->
        <div class="sidebar-heading">
            General
        </div>

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-house-user"></i>
                <span>General</span>
            </a>
        </li>

        <!-- Nav Item - Dosen -->
        <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-user-tie"></i>
                <span>Dosen</span>
            </a>
        </li>

        <!-- Nav Item - Jadwal -->
        <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal</span>
            </a>
        </li>

        <!-- Nav Item - Sempro -->
        <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-book"></i>
                <span>Sempro</span>
            </a>
        </li>

        <!-- Nav Item - Hasil Seminar -->
        <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-file-alt"></i>
                <span>Hasil Seminar</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Heading -->
        <div class="sidebar-heading">
            Tools
        </div>

        <!-- Nav Item - Help -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-question-circle"></i>
                <span>Help</span>
            </a>
        </li>

        <!-- Nav Item - Logout -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
</div>