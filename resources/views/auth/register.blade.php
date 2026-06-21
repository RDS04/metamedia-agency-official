<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- LEFT SIDE -->
        <div class="hidden lg:flex lg:w-1/2 relative">

            <img src="{{ asset('storage/gedungMetamedia.webp') }}" alt="Gedung Kampus"
                class="w-full h-screen object-cover">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-[#001B44]/75"></div>

            <!-- Content -->
            <div class="absolute inset-0 flex flex-col justify-center px-16 text-white">

                <h1 class="text-5xl font-bold leading-tight mb-5">
                    Bergabung Menjadi Agen Mahasiswa
                </h1>

                <p class="text-lg text-gray-200 leading-relaxed max-w-lg">
                    Daftarkan diri Anda sebagai Mahasiswa, Alumni, Orang Tua,
                    Dosen, Karyawan, maupun Mitra untuk mendapatkan akses ke
                    seluruh layanan dan informasi kampus secara terintegrasi.
                </p>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="flex-1 flex items-center justify-center p-6">

            <div class="w-full max-w-lg">

                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

                    <!-- Header -->
                    <div class="px-8 pt-8 text-center">

                        <div class="flex justify-center mb-4">
                            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-20 w-auto">
                        </div>

                        <h1 class="text-3xl font-bold text-gray-800">
                            Registrasi Akun
                        </h1>

                        <p class="text-gray-500 mt-2">
                            Lengkapi data untuk membuat akun baru
                        </p>

                    </div>

                    <!-- Form -->
                    <div class="p-8">

                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Validation Error --}}
                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap
                                    </label>

                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Status
                                    </label>

                                    <select name="status"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">

                                        <option value="">Pilih Status</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="alumni">Alumni</option>
                                        <option value="orang_tua">Orang Tua</option>
                                        <option value="dosen_karyawan">Dosen/Karyawan</option>
                                        <option value="mitra">Instansi/Mitra</option>

                                    </select>
                                </div>

                                <!-- WhatsApp -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor WhatsApp
                                    </label>

                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email
                                    </label>

                                    <input type="email" name="email" value="{{ old('email') }}"
                                        placeholder="nama@email.com"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Password
                                    </label>

                                    <input type="password" name="password" placeholder="Password"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">
                                </div>

                                <!-- Konfirmasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password
                                    </label>

                                    <input type="password" name="password_confirmation"
                                        placeholder="Konfirmasi Password"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">
                                </div>

                            </div>

                            <button type="submit"
                                class="w-full bg-[#018FD7] hover:bg-[#017bb8] text-white font-semibold py-3 rounded-xl shadow-lg transition">

                                Daftar Sekarang
                            </button>

                        </form>

                        <!-- Login -->
                        <div class="mt-6 text-center border-t pt-6">

                            <p class="text-gray-600 text-sm">
                                Sudah memiliki akun?

                                <a href="{{ route('auth.login') }}"
                                    class="text-[#018FD7] font-semibold hover:underline">

                                    Masuk
                                </a>

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <x-lilin />

</body>

</html>