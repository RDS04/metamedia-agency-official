<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin - Agent PMB</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-slate-200">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#018FD7] to-[#0277BD] px-8 py-5">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-white">
                                Register Admin
                            </h2>
                            <p class="text-blue-100 text-sm">
                                Buat akun administrator baru
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Form -->
                <form action="{{ route('adminregisterStore') }}" method="POST" class="p-8">
                    @csrf

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Nama -->
                    <div class="mb-5">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                    </div>
                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                    </div>
                    <!-- Password -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" type="password" name="password" placeholder="Masukkan password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">

                            <button type="button" onclick="togglePassword('password')"
                                class="absolute right-4 top-3 text-gray-500">
                                Lihat
                            </button>
                        </div>
                    </div>
                    <!-- Konfirmasi Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#018FD7] focus:ring-4 focus:ring-blue-100 outline-none transition">
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute right-4 top-3 text-gray-500">
                                Lihat
                            </button>
                        </div>
                    </div>
                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-[#018FD7] hover:bg-[#0175b2] text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg">
                        Register
                    </button>

                    <!-- Divider -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t"></div>
                        <span class="px-3 text-sm text-gray-400">
                            atau
                        </span>
                        <div class="flex-1 border-t"></div>
                    </div>

                    <!-- Login -->
                    <div class="text-center">

                        <span class="text-gray-500">
                            Sudah memiliki akun?
                        </span>

                        <a href="{{ route('login.admin') }}" class="text-[#018FD7] font-semibold hover:underline">

                            Login Sekarang

                        </a>

                    </div>

                </form>

            </div>

            <!-- Footer -->
            <div class="text-center mt-6">

                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Agent PMB.
                    All Rights Reserved.
                </p>

            </div>

        </div>

    </div>

    <script>

        function togglePassword(fieldId) {

            let field = document.getElementById(fieldId);

            if (field.type === 'password') {

                field.type = 'text';

            } else {

                field.type = 'password';

            }

        }

    </script>
    <x-lilin />
</body>

</html>
