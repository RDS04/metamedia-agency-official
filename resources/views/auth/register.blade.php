<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#018FD7] to-[#0d6ea5] flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="px-8 pt-8 text-center">

                <!-- Logo -->
                <div class="flex justify-center mb-5">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-20 w-auto">
                </div>

                <h1 class="text-2xl font-bold text-gray-800">
                    Registrasi Akun
                </h1>

                <p class="text-gray-500 mt-2 text-sm">
                    Bergabung dan mulai perjalanan pendidikan Anda
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

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>

                        <select name="status"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none">

                            <option value="">
                                -- Pilih Status Agent --
                            </option>

                            <option value="mahasiswa" {{ old('status') == 'mahasiswa' ? 'selected' : '' }}>
                                Mahasiswa
                            </option>

                            <option value="alumni" {{ old('status') == 'alumni' ? 'selected' : '' }}>
                                Alumni
                            </option>

                            <option value="orang_tua" {{ old('status') == 'orang_tua' ? 'selected' : '' }}>
                                Orang Tua
                            </option>

                            <option value="dosen_karyawan" {{ old('status') == 'dosen_karyawan' ? 'selected' : '' }}>
                                Dosen/karyawan
                            </option>

                            <option value="mitra" {{ old('status') == 'mitra' ? 'selected' : '' }}>
                                Instansi / Mitra
                            </option>

                        </select>

                        @error('status')
                            <small class="text-red-500">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor WhatsApp
                        </label>

                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>

                        <input type="password" name="password" placeholder="Masukkan password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>

                        <input type="password" name="password_confirmation" placeholder="Ulangi password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-[#018FD7] hover:bg-[#017bb8] text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg">

                        Daftar Sekarang
                    </button>

                </form>

                <!-- Login -->
                <div class="mt-6 text-center">
                    <p class="text-gray-500 text-sm">
                        Sudah memiliki akun?

                        <a href="{{ route('auth.login') }}" class="text-[#018FD7] font-semibold hover:underline">
                            Masuk
                        </a>
                    </p>
                </div>

            </div>

        </div>

    </div>

</body>

</html>