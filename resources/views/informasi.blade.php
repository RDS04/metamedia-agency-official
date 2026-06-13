<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Mahasiswa Baru</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" class="h-10">
                    <span class="font-bold text-xl text-[#018FD7]">
                        Agent PMB
                    </span>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex items-center gap-8">

                    <a href="#" class="text-gray-700 hover:text-[#018FD7]">
                        Beranda
                    </a>

                    <a href="#" class="text-gray-700 hover:text-[#018FD7]">
                        Tentang
                    </a>

                    <a href="#" class="text-gray-700 hover:text-[#018FD7]">
                        Program Studi
                    </a>

                    <a href="#" class="text-gray-700 hover:text-[#018FD7]">
                        Kontak
                    </a>
                </div>

                <!-- Button -->
                <div class="flex gap-3">

                    <a href="{{ route('auth.login') }}"
                        class="px-5 py-2 border border-[#018FD7] text-[#018FD7] rounded-lg hover:bg-[#018FD7] hover:text-white transition">

                        Login
                    </a>

                    <a href="{{ route('auth.register') }}"
                        class="px-5 py-2 bg-[#018FD7] text-white rounded-lg hover:bg-[#017bb8] transition">

                        Register
                    </a>

                </div>

            </div>

        </div>
    </nav>

    <!-- Hero Slider -->
    <section class="relative h-[500px] overflow-hidden">

        <div id="slider" class="h-full">

            <div class="slide bg-cover bg-center h-full flex items-center"
                style="background-image:url('{{ asset('backgraund.webp') }}');">

                <div class="max-w-7xl mx-auto px-6 text-white">

                    <h1 class="text-5xl font-bold mb-4">
                        Wujudkan Masa Depan Bersama Kami
                    </h1>

                    <p class="text-xl mb-6">
                        Pendaftaran Mahasiswa Baru Tahun Akademik 2026
                    </p>

                    <a href="{{ route('auth.register') }}"
                        class="bg-[#018FD7] px-6 py-3 rounded-lg">
                        Daftar Sekarang
                    </a>

                </div>

            </div>

        </div>

    </section>

    <!-- Keunggulan -->
    <section class="py-20">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-4xl font-bold text-center mb-12">
                Mengapa Memilih Kami?
            </h2>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="bg-white p-8 rounded-2xl shadow">
                    <h3 class="font-bold text-xl mb-3">
                        Akreditasi Unggul
                    </h3>

                    <p class="text-gray-600">
                        Program studi terakreditasi dan diakui secara nasional.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow">
                    <h3 class="font-bold text-xl mb-3">
                        Beasiswa
                    </h3>

                    <p class="text-gray-600">
                        Tersedia berbagai program beasiswa bagi mahasiswa baru.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow">
                    <h3 class="font-bold text-xl mb-3">
                        Karir
                    </h3>

                    <p class="text-gray-600">
                        Didukung pusat karir dan jaringan alumni yang luas.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <!-- Statistik -->
    <section class="bg-[#018FD7] py-16">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-4 text-center text-white gap-8">

                <div>
                    <h3 class="text-4xl font-bold">12.000+</h3>
                    <p>Mahasiswa Aktif</p>
                </div>

                <div>
                    <h3 class="text-4xl font-bold">25</h3>
                    <p>Program Studi</p>
                </div>

                <div>
                    <h3 class="text-4xl font-bold">500+</h3>
                    <p>Dosen</p>
                </div>

                <div>
                    <h3 class="text-4xl font-bold">20.000+</h3>
                    <p>Alumni</p>
                </div>

            </div>

        </div>

    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h3 class="font-bold text-xl mb-3">
                Agent Mahasiswa Baru
            </h3>

            <p class="text-gray-400">
                © 2026 All Rights Reserved
            </p>

        </div>

    </footer>

</body>
</html>