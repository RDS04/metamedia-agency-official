<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Agen Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#018FD7] to-[#0d6ea5] flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <!-- Card Login -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="px-8 pt-8 text-center">

                <!-- Logo -->
                <div class="flex justify-center mb-5">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-20 w-auto">
                </div>

                <h1 class="text-2xl font-bold text-gray-800">
                    Masuk
                </h1>

                <p class="text-gray-500 mt-2 text-sm">
                    Masuk ke akun Anda untuk melanjutkan
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

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor WhatsApp
                        </label>
                        <input 
                            type="text" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="text-sm font-medium text-gray-700">Password</label>
                            <a href="#" class="text-sm text-[#018FD7] hover:text-[#0177BB] font-medium">
                                Lupa Password?
                            </a>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            class="w-4 h-4 text-[#018FD7] rounded border-gray-300 focus:ring-[#018FD7]">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                    </div>

                    <!-- Tombol Login -->
                    <button 
                        type="submit"
                        class="w-full bg-[#018FD7] hover:bg-[#017bb8] text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg">
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-200"></div>
                    <span class="px-3 text-xs text-gray-500 font-light">ATAU</span>
                    <div class="flex-1 border-t border-gray-200"></div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        Belum memiliki akun?
                        <a href="{{ route('auth.register') }}" class="text-[#018FD7] font-semibold hover:text-[#0177BB]">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
