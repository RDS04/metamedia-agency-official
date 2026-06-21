<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        {{-- Sidebar --}}
        @include('auth.layout.sidebar')

        <div class="flex-1 flex flex-col">

            {{-- Header --}}
            @include('auth.layout.header')

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('auth.layout.footer')

        </div>

    </div>

    @if(!Auth::guard('admin')->check() && Auth::check() && !Auth::user()->is_active)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/75 px-6">
            <div class="w-full max-w-md rounded-3xl bg-white p-8 text-center shadow-2xl">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-900">
                    Akun Anda sedang dinonaktifkan
                </h2>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Anda tidak bisa melihat atau mengelola data. Silakan hubungi admin jika akun perlu diaktifkan kembali.
                </p>

                <a href="{{ route('informasi') }}"
                    class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-[#018FD7] px-5 py-3 font-semibold text-white transition hover:bg-[#017bb8]">
                    Kembali ke Informasi
                </a>
            </div>
        </div>
    @endif

    <x-lilin />

</body>

</html>
