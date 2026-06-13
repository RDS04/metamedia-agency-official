<aside class="w-72 bg-gray-900 text-gray-300 min-h-screen border-r border-gray-800 overflow-y-auto">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-gray-800">

        <div class="w-10 h-10 rounded-full bg-[#018FD7] flex items-center justify-center">
            <span class="text-white font-bold text-lg">A</span>
        </div>

        <span class="ml-3 text-xl font-bold text-white">
            Agent PMB
        </span>

    </div>

    <!-- User Info -->
    <div class="p-4 border-b border-gray-800">

        <div class="flex items-center">

            <img src="https://i.pravatar.cc/50" class="w-12 h-12 rounded-full">

            <div class="ml-3">
                <h4 class="text-white font-semibold text-sm">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </h4>
                <p class="text-xs text-green-400 flex items-center">
                    <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-1"></span>Online
                </p>
            </div>

        </div>

    </div>

    <!-- Menu -->
    <nav class="mt-4 px-3">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg bg-[#018FD7] text-white font-medium transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z"/>
            </svg>
            <span class="ml-3">Dashboard</span>
        </a>

        <!-- Master Data -->
        <div x-data="{ open: false }" class="mt-3">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 transition font-medium">

                <div class="flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                    <span class="ml-3">Master Data</span>
                </div>

                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>

            </button>

            <div x-show="open" x-transition class="mt-2 space-y-1 bg-gray-800 rounded-lg p-2 ml-2">

                <a href="#" class="block py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white transition text-sm">
                    <span class="flex items-center">
                        <span class="inline-block w-1.5 h-1.5 bg-[#018FD7] rounded-full mr-2"></span>
                        Mahasiswa
                    </span>
                </a>

                <a href="#" class="block py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white transition text-sm">
                    <span class="flex items-center">
                        <span class="inline-block w-1.5 h-1.5 bg-[#018FD7] rounded-full mr-2"></span>
                        Alumni
                    </span>
                </a>

                <a href="#" class="block py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white transition text-sm">
                    <span class="flex items-center">
                        <span class="inline-block w-1.5 h-1.5 bg-[#018FD7] rounded-full mr-2"></span>
                        Orang Tua
                    </span>
                </a>

            </div>

        </div>

        <!-- Referral -->
        <a href="{{route('Add.agent') }}" class="flex items-center px-4 py-3 mt-3 rounded-lg text-gray-300 hover:bg-gray-800 transition font-medium">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16.5 12c1.38 0 2.49-1.12 2.49-2.5S17.88 7 16.5 7 14 8.12 14 9.5s1.12 2.5 2.5 2.5zm-9-2c1.66 0 2.99-1.34 2.99-3S8.66 4 7 4 4 5.34 4 7s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm9 0c-.29 0-.62.02-.97.05 1.16.89 1.97 2.47 1.97 4.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
            <span class="ml-3">Tambah Agent</span>
        </a>

        <!-- Komisi -->
        <a href="#" class="flex items-center px-4 py-3 mt-2 rounded-lg text-gray-300 hover:bg-gray-800 transition font-medium">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
            <span class="ml-3">Komisi</span>
        </a>

        <!-- Laporan -->
        <a href="#" class="flex items-center px-4 py-3 mt-2 rounded-lg text-gray-300 hover:bg-gray-800 transition font-medium">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2V17zm4 0h-2V7h2V17zm4 0h-2v-4h2V17z"/>
            </svg>
            <span class="ml-3">Laporan</span>
        </a>

        <!-- Pengaturan -->
        <a href="#" class="flex items-center px-4 py-3 mt-2 rounded-lg text-gray-300 hover:bg-gray-800 transition font-medium">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.62l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.09-.47 0-.59.22L2.74 8.87c-.12.21-.08.48.1.62l2.03 1.58c-.05.3-.07.62-.07.94 0 .33.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.62l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.48-.1-.62l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
            </svg>
            <span class="ml-3">Pengaturan</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-700 my-4"></div>

        <!-- Logout -->
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="w-full text-left flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition font-medium">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                <span class="ml-3">Logout</span>
            </button>
        </form>

    </nav>

</aside>