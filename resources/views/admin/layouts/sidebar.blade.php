<div class="flex flex-col h-full">
    <!-- Menu Utama -->
    <div class="p-4">
        <div class="flex items-center space-x-4 mt-3">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <img src="/assets/img/iku.png" alt="Logo" class="w-14 h-14">
            <span class="text-lg font-semibold text-teal-700">SEMPRO UIN Malang</span>
        </div>
        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 mt-10">General</p>
        <ul class="text-sm text-gray-600 space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-users"></i>
                        <span>User</span>
                    </div>
                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </button>
                <ul x-show="open" class="pl-6 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-users"></i>
                            <span>User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mahasiswa.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mahasiswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dosen.all.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.dosen.all.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-user-tie"></i>
                            <span>Dosen</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-tie"></i>
                        <span>Dosen</span>
                    </div>
                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </button>
                <ul x-show="open" class="pl-6 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('admin.dosen.pembimbing.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.dosen.pembimbing.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Pembimbing</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dosen.penguji.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.dosen.penguji.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-user-check"></i>
                            <span>Penguji</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal</span>
                    </div>
                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </button>
                <ul x-show="open" class="pl-6 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('admin.jadwal.mata-kuliah.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.jadwal.mata-kuliah.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-book-open"></i>
                            <span>Jadwal Mata Kuliah</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.jadwal.sempro.index') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.jadwal.sempro.*') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                            <i class="fas fa-calendar-check"></i>
                            <span>Jadwal Sempro</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.pengajuan-sempro.index') }}"
                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-book"></i>
                    <span>Pengajuan Sempro</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.hasil.sempro.index') }}"
                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-file-alt"></i>
                    <span>Hasil Seminar</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Tools -->
    <div class="p-4 mt-auto">
        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Tools</p>
        <ul class="text-sm text-gray-600 space-y-2">
            <li>
                <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-question-circle"></i>
                    <span>Help</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-cog"></i>
                    <span>Setting</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-3 p-2 rounded-lg text-red-500 hover:bg-gray-200 w-full text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
