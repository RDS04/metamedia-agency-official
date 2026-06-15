@php
    $isAdmin = Auth::guard('admin')->check();

    $userName = $isAdmin
        ? Auth::guard('admin')->user()->name
        : (Auth::user()->name ?? 'Agent');
@endphp

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

    <!-- User -->
    <div class="p-4 border-b border-gray-800">

        <div class="flex items-center">

            <img src="https://i.pravatar.cc/50" class="w-12 h-12 rounded-full">

            <div class="ml-3">

                <h4 class="text-white font-semibold text-sm">
                    {{ $userName }}
                </h4>

                <p class="text-xs text-green-400 flex items-center">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                    Online
                </p>

            </div>

        </div>

    </div>

    <nav class="mt-4 px-3">

        {{-- DASHBOARD ADMIN --}}
        @if($isAdmin)

            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg bg-[#018FD7] text-white font-medium">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z" />
                </svg>

                <span class="ml-3">
                    Dashboard
                </span>

            </a>

            {{-- MASTER DATA --}}
            <div x-data="{ open: false }" class="mt-3">

                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-800">

                    <div class="flex items-center">

                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                        </svg>

                        <span class="ml-3">
                            Master Data
                        </span>

                    </div>

                    <span x-text="open ? '-' : '+'"></span>

                </button>

                <div x-show="open" x-transition class="mt-2 bg-gray-800 rounded-lg p-2">

                    <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">

                        Mahasiswa

                    </a>

                    <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">

                        Alumni

                    </a>

                    <a href="#" class="block py-2 px-4 rounded hover:bg-gray-700">

                        Orang Tua

                    </a>

                </div>

            </div>

        @endif

        {{-- AGENT --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-3 rounded-lg bg-[#018FD7] text-white font-medium">

            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z" />
            </svg>

            <span class="ml-3">
                Dashboard
            </span>

        </a>
        <div x-data="{ open: false }" class="mt-3">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-800">

                <div class="flex items-center">

                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M16.5 12c1.38 0 2.49-1.12 2.49-2.5S17.88 7 16.5 7 14 8.12 14 9.5s1.12 2.5 2.5 2.5zm-9-2c1.66 0 2.99-1.34 2.99-3S8.66 4 7 4 4 5.34 4 7s1.34 3 3 3z" />
                    </svg>

                    <span class="ml-3">
                        Agent
                    </span>

                </div>

                <span x-text="open ? '-' : '+'"></span>

            </button>

            <div x-show="open" x-transition class="mt-2 bg-gray-800 rounded-lg p-2">

                <a href="{{ route('agen.Create') }}" class="block py-2 px-4 rounded hover:bg-gray-700">

                    Tambah Agent

                </a>

                <a href="{{ route('agen.Show') }}" class="block py-2 px-4 rounded hover:bg-gray-700">

                    Daftar Agent

                </a>

            </div>

        </div>

        {{-- MENU KHUSUS ADMIN --}}
        @if($isAdmin)

            <a href="#" class="flex items-center px-4 py-3 mt-2 rounded-lg hover:bg-gray-800">

                <span class="ml-3">
                    Komisi
                </span>

            </a>

            <a href="#" class="flex items-center px-4 py-3 mt-2 rounded-lg hover:bg-gray-800">

                <span class="ml-3">
                    Laporan
                </span>

            </a>

            <a href="#" class="flex items-center px-4 py-3 mt-2 rounded-lg hover:bg-gray-800">

                <span class="ml-3">
                    Pengaturan
                </span>

            </a>

        @endif

        <div class="border-t border-gray-700 my-4"></div>

        {{-- LOGOUT --}}
        <form action="{{ $isAdmin ? route('logout.admin') : route('auth.logout') }}" method="POST">

            @csrf

            @unless($isAdmin)
                @method('PUT')
            @endunless

            <button type="submit"
                class="w-full text-left flex items-center px-4 py-3 rounded-lg hover:bg-red-600 hover:text-white transition">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                </svg>

                <span class="ml-3">
                    Logout
                </span>

            </button>

        </form>

    </nav>

</aside>