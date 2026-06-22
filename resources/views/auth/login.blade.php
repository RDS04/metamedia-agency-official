<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Agen Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- LEFT SIDE -->
        <div class="hidden lg:flex lg:w-1/2 relative">

            <!-- Gambar Gedung Kampus -->
            <img src="{{ asset('storage/gedungMetamedia.webp') }}" alt="Gedung Kampus"
                class="w-full h-screen object-cover">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-[#001B44]/70"></div>

            <!-- Teks -->
            <div class="absolute inset-0 flex flex-col justify-center px-16 text-white">

                <h1 class="text-5xl font-bold leading-tight mb-5">
                    Sistem Agen Universitas Metamedia
                </h1>

                <p class="text-lg text-gray-200 max-w-lg">
                </p>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="flex-1 flex items-center justify-center p-6">

            <div class="w-full max-w-md">

                <div class="bg-white rounded-3xl shadow-xl p-8">

                    <!-- Logo -->
                    <div class="text-center mb-6">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-20 mx-auto mb-4">

                        <h2 class="text-3xl font-bold text-gray-800">
                            Masuk
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Silahkan login ke akun Anda
                        </p>
                    </div>

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error --}}
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">
                                    Password
                                </label>

                                <a href="#" class="text-sm text-[#018FD7]">
                                    Lupa Password?
                                </a>
                            </div>

                            <input type="password" name="password" placeholder="Masukkan Password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#018FD7]">

                            <label class="ml-2 text-sm text-gray-600">
                                Ingat Saya
                            </label>
                        </div>

                        <!-- Button -->
                        <button type="submit"
                            class="w-full bg-[#018FD7] hover:bg-[#0077b5] text-white py-3 rounded-xl font-semibold transition">

                            Masuk
                        </button>

                    </form>

                    <!-- Divider -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t"></div>
                        <span class="px-3 text-gray-400 text-xs">
                            ATAU
                        </span>
                        <div class="flex-1 border-t"></div>
                    </div>

                    <!-- Register -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Belum memiliki akun?

                            <a href="{{ route('auth.register') }}" class="text-[#018FD7] font-semibold">

                                Daftar Sekarang
                            </a>
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <x-lilin />

</body>

</html>
