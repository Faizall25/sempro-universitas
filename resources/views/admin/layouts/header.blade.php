<div class="flex items-center justify-between p-4">
    <!-- Search Bar -->
    <div class="flex-1 max-w-md mx-4">
        <form action="{{ request()->url() }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="Search for..."
                class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500">
            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- User Dropdown -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700">
            <span>Selamat Datang, {{ Auth::user()->name }}</span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div x-show="open" @click.away="open = false"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i
                    class="fas fa-user mr-2"></i>Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100"><i
                        class="fas fa-sign-out-alt mr-2"></i>Logout</button>
            </form>
        </div>
    </div>
</div>
