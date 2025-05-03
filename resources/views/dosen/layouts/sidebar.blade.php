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
                <a href="{{ route('dosen.home') }}" class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('dosen.home') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen.profile') }}" class="flex items-center space-x-3 p-2 rounded-lg  {{ request()->routeIs('dosen.profile') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-user-alt"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen.profile') }}" class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('dosen.profile') ? 'bg-gray-200 text-teal-700' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-calendar"></i>
                    <span>Pengajuan Proposal</span>
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
                    <button type="submit" class="flex items-center space-x-3 p-2 rounded-lg text-red-500 hover:bg-gray-200 w-full text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>