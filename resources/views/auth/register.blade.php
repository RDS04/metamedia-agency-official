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

                        @if(session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                                {{ session('error') }}
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

                        @if(session('pending_registration'))
                            <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4">
                                <p class="text-sm font-semibold text-blue-900">
                                    Verifikasi Email
                                </p>
                                <p class="mt-1 text-sm text-blue-700">
                                    Masukkan 6 digit kode OTP yang dikirim ke
                                    <span class="font-semibold">{{ session('pending_registration.email') }}</span>.
                                </p>
                            </div>

                            <form action="{{ route('register.verify-otp') }}" method="POST" class="space-y-5">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode OTP
                                    </label>

                                    <input type="text" name="otp" maxlength="6" inputmode="numeric"
                                        autocomplete="one-time-code" placeholder="Masukkan 6 digit OTP"
                                        class="w-full px-4 py-3 text-center tracking-[0.45em] rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">
                                </div>

                                <button type="submit"
                                    class="w-full bg-[#018FD7] hover:bg-[#017bb8] text-white font-semibold py-3 rounded-xl shadow-lg transition">
                                    Verifikasi & Selesaikan Registrasi
                                </button>
                            </form>

                            <form action="{{ route('register.resend-otp') }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit"
                                    class="w-full border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-3 rounded-xl transition">
                                    Kirim Ulang OTP
                                </button>
                            </form>

                            <form action="{{ route('register.change-data') }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit"
                                    class="w-full text-[#018FD7] hover:text-[#017bb8] font-semibold py-2 rounded-xl transition">
                                    Ubah Email atau Data Registrasi
                                </button>
                            </form>
                        @else
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
                                            <option value="mahasiswa" {{ old('status') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                            <option value="alumni" {{ old('status') === 'alumni' ? 'selected' : '' }}>Alumni</option>
                                            <option value="orang_tua" {{ old('status') === 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="dosen_karyawan" {{ old('status') === 'dosen_karyawan' ? 'selected' : '' }}>Dosen/Karyawan</option>
                                            <option value="mitra" {{ old('status') === 'mitra' ? 'selected' : '' }}>Instansi/Mitra</option>

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
                        @endif

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
