<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <title>Login Admin - Agent PMB</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-slate-200">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#018FD7] to-[#0277BD] px-8 py-5">

                <div class="flex items-center">

                    <div class="w-14 h-14 bg-white rounded-2xl shadow-lg flex items-center justify-center">

                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('login.admin.process') }}" method="POST" class="p-8">

                @csrf

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

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@email.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">

                </div>

                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <div class="relative">

                        <input id="password" type="password" name="password" placeholder="Masukkan password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">

                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-3 text-gray-500">
                            👁️
                        </button>

                    </div>

                </div>

                <div class="flex items-center justify-between mb-6">

                    <label class="flex items-center">

                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#018FD7]">

                        <span class="ml-2 text-sm text-gray-600">
                            Remember Me
                        </span>

                    </label>

                    <a href="#" class="text-sm text-[#018FD7] hover:underline">

                        Lupa Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-[#018FD7] hover:bg-[#0175b2] text-white font-semibold py-3 rounded-xl transition shadow-lg">

                    Login

                </button>

                <div class="flex items-center my-6">

                    <div class="flex-1 border-t"></div>

                    <span class="px-3 text-sm text-gray-400">
                        atau
                    </span>

                    <div class="flex-1 border-t"></div>

                </div>

                <div class="text-center">

                    <span class="text-gray-500">
                        Belum memiliki akun?
                    </span>

                    <a href="{{ route('register.admin') }}" class="text-[#018FD7] font-semibold hover:underline">

                        Register Sekarang

                    </a>

                </div>

            </form>

        </div>
        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} Agent PMB. All Rights Reserved.
            </p>
        </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            let password = document.getElementById('password');
            if (password.type === 'password') {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>
</body>

</html>
