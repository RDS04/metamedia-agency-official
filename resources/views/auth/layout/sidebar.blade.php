@php
    $isAdmin = Auth::guard('admin')->check();

    $userName = $isAdmin
        ? Auth::guard('admin')->user()->name
        : (Auth::user()->name ?? 'Agent');

    $isActive = fn(...$routes) => request()->routeIs($routes);

    $linkClass = fn($active = false) => 'flex items-center px-4 py-3 rounded-lg transition ' .
        ($active ? 'bg-[#018FD7] text-white font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white');

    $childLinkClass = fn($active = false) => 'block py-2 px-4 rounded transition ' .
        ($active ? 'bg-[#018FD7] text-white font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white');

    $groupButtonClass = fn($active = false) => 'w-full flex items-center justify-between px-4 py-3 rounded-lg transition ' .
        ($active ? 'bg-gray-800 text-white font-medium' : 'text-gray-300 hover:bg-gray-800 hover:text-white');

    $masterOpen = $isActive('listAgent', 'priode', 'exportregister.*');
    $agentOpen = $isActive('agen.*');
    $komisiOpen = $isActive('komisi.*');
    $importOpen = $isActive('mahasiswa.*');
@endphp

<aside class="w-72 bg-gray-900 text-gray-300 min-h-screen border-r border-gray-800 overflow-y-auto">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-gray-800">

        <div class="w-10 h-10 rounded-full bg-[#018FD7] flex items-center justify-center">
            <span class="text-white font-bold text-lg">A</span>
        </div>
        @if ($isAdmin)
            <span class="ml-3 text-xl font-bold text-white">
                Admin Agent PMB
            </span>
        @endif
        @if (!$isAdmin)
            <span class="ml-3 text-xl font-bold text-white">
                Agent PMB
            </span>
        @endif

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
        @if(!$isAdmin)
            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard') }}" class="{{ $linkClass($isActive('dashboard')) }}">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z" />
                </svg>

                <span class="ml-3">
                    Dashboard
                </span>

            </a>
        @endif
        @if($isAdmin)
            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard.admin') }}" class="{{ $linkClass($isActive('dashboard.admin')) }}">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z" />
                </svg>

                <span class="ml-3">
                    Dashboard
                </span>

            </a>
        @endif
        {{-- MASTER DATA (ADMIN ONLY) --}}
        @if($isAdmin)

            <div x-data="{ open: {{ $masterOpen ? 'true' : 'false' }} }" class="mt-3">

                <button @click="open = !open" class="{{ $groupButtonClass($masterOpen) }}">

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

                    <a href="{{ route('listAgent') }}" class="{{ $childLinkClass($isActive('listAgent')) }}">
                        Agent
                    </a>
                    <a href="{{ route('priode') }}" class="{{ $childLinkClass($isActive('priode')) }}">
                        Priode PMB
                    </a>
                    <a href="{{ route('exportregister.index') }}" class="{{ $childLinkClass($isActive('exportregister.*')) }} flex items-center gap-2">
                        <i class="ti ti-file-import text-sm"></i>
                        Registrasi via Excel
                    </a>


                </div>

            </div>

        @endif

        {{-- AGENT (USER ONLY) --}}
        @if(!$isAdmin)

            <div x-data="{ open: {{ $agentOpen ? 'true' : 'false' }} }" class="mt-3">

                <button @click="open = !open" class="{{ $groupButtonClass($agentOpen) }}">

                    <div class="flex items-center">

                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16.5 12c1.38 0 2.49-1.12 2.49-2.5S17.88 7 16.5 7 14 8.12 14 9.5s1.12 2.5 2.5 2.5zm-9-2c1.66 0 2.99-1.34 2.99-3S8.66 4 7 4 4 5.34 4 7s1.34 3 3 3z" />
                        </svg>

                        <span class="ml-3">
                            Mahasiswa
                        </span>

                    </div>

                    <span x-text="open ? '-' : '+'"></span>

                </button>

                <div x-show="open" x-transition class="mt-2 bg-gray-800 rounded-lg p-2">

                    <a href="{{ route('agen.Create') }}" class="{{ $childLinkClass($isActive('agen.Create')) }}">
                        Tambah Mahasiswa Baru
                    </a>

                    <a href="{{ route('agen.Show') }}"
                        class="{{ $childLinkClass($isActive('agen.Show', 'agen.Detail', 'agen.Edit')) }}">
                        Daftar Mahasiswa
                    </a>

                </div>

            </div>

        @endif

        {{-- KOMISI (ADMIN ONLY) --}}
        @if($isAdmin)

            <div x-data="{ open: {{ $komisiOpen ? 'true' : 'false' }} }" class="mt-3">

                <button @click="open = !open" class="{{ $groupButtonClass($komisiOpen) }}">

                    <div class="flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                        </svg>

                        <span class="ml-3">
                            Komisi
                        </span>
                    </div>

                    <span x-text="open ? '-' : '+'"></span>

                </button>

                <div x-show="open" x-transition class="mt-2 bg-gray-800 rounded-lg p-2">
                    <a href="{{ route('komisi.mao') }}" class="{{ $childLinkClass($isActive('komisi.mao')) }}">
                        Mahasiswa & Ortu & Alumni
                    </a>

                    <a href="{{ route('komisi.dosen-karyawan') }}"
                        class="{{ $childLinkClass($isActive('komisi.dosen-karyawan')) }}">
                        Dosen & Karyawan
                    </a>

                    <a href="{{ route('komisi.mitra') }}" class="{{ $childLinkClass($isActive('komisi.mitra')) }}">
                        Mitra / Instansi
                    </a>
                </div>

            </div>

        @endif
        @if ($isAdmin)
            <div x-data="{ open: {{ $importOpen ? 'true' : 'false' }} }" class="mt-3">

                <button @click="open = !open" class="{{ $groupButtonClass($importOpen) }}">

                    <div class="flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                        </svg>

                        <span class="ml-3">
                            Import Data Mahasiswa
                        </span>
                    </div>

                    <span x-text="open ? '-' : '+'"></span>

                </button>

                <div x-show="open" x-transition class="mt-2 bg-gray-800 rounded-lg p-2">
                    <a href="{{ route('mahasiswa.create') }}" class="{{ $childLinkClass($isActive('mahasiswa.create')) }}">
                        Import / Input Mahasiswa
                    </a>

                    <a href="{{ route('mahasiswa.index') }}"
                        class="{{ $childLinkClass($isActive('mahasiswa.index', 'mahasiswa.edit')) }}">
                        Data Mahasiswa
                    </a>

                </div>

            </div>
        @endif
        @if (!$isAdmin)


            {{-- LAPORAN --}}
            <a href="{{ route('laporan') }}" class="{{ $linkClass($isActive('laporan')) }} mt-3">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54-4.5 5.71h12l-3.45-4.71z" />
                </svg>

                <span class="ml-3">
                    Laporan
                </span>

            </a>
        @endif
        @if ($isAdmin)
            {{-- LAPORAN --}}
            <a href="{{ route('dataCamaba') }}" class="{{ $linkClass($isActive('dataCamaba')) }} mt-3">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54-4.5 5.71h12l-3.45-4.71z" />
                </svg>

                <span class="ml-3">
                    Laporan
                </span>

            </a>
        @endif
        {{-- DAFTAR PESAN DAN KESAN (ADMIN ONLY) --}}
        @if($isAdmin)

            <a href="{{ route('pesan.index') }}" class="{{ $linkClass($isActive('pesan.*')) }} mt-3">

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" />
                </svg>

                <span class="ml-3">
                    Daftar Pesan Dan Kesan
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