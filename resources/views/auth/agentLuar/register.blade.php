<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Agent Umum — PMB Metamedia</title>
    <meta name="description"
        content="Daftar sebagai Agent Umum PMB Metamedia menggunakan kode referral dari Agent Anda.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-left {
            background: linear-gradient(135deg, #001B44 0%, #013A7A 60%, #018FD7 100%);
        }

        .input-focus {
            transition: all .2s;
        }

        .input-focus:focus {
            border-color: #018FD7;
            box-shadow: 0 0 0 4px rgba(1, 143, 215, .12);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #018FD7, #0073b1);
            transition: all .2s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0073b1, #005f94);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(1, 143, 215, .35);
        }

        .badge-referral {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-color: #7dd3fc;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- LEFT SIDE -->
        <div class="hidden lg:flex lg:w-5/12 relative overflow-hidden gradient-left">

            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <img src="{{ asset('storage/gedungMetamedia.webp') }}" alt="Gedung Kampus"
                class="absolute inset-0 w-full h-full object-cover opacity-20">

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center px-14 text-white">

                <div class="mb-8">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo Metamedia"
                        class="h-14 w-auto brightness-0 invert opacity-90">
                </div>

                <h1 class="text-4xl font-extrabold leading-tight mb-4">
                    Bergabung Sebagai<br>
                    <span class="text-[#7dd3fc]">Agent Umum</span>
                </h1>

                <p class="text-blue-200 leading-relaxed max-w-sm text-sm mb-8">
                    Bantu lebih banyak calon mahasiswa bergabung ke Universitas Metamedia dan dapatkan komisi setiap
                    referral sukses.
                </p>

                <!-- Steps -->
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-7 h-7 rounded-full bg-[#018FD7] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold">1</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Dapatkan Kode Referral</p>
                            <p class="text-blue-300 text-xs mt-0.5">Minta kode dari Agent yang mengundang Anda
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div
                            class="w-7 h-7 rounded-full bg-[#018FD7] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold">2</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Daftar & Aktivasi Akun</p>
                            <p class="text-blue-300 text-xs mt-0.5">Isi form registrasi dengan kode referral yang valid
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div
                            class="w-7 h-7 rounded-full bg-[#018FD7] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold">3</span>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Mulai Rekrut & Dapatkan Komisi</p>
                            <p class="text-blue-300 text-xs mt-0.5">Tambahkan calon mahasiswa dan pantau progres Anda
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex-1 flex items-center justify-center p-6 bg-slate-50">

            <div class="w-full max-w-xl">

                <!-- Mobile Logo -->
                <div class="flex justify-center mb-6 lg:hidden">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-16 w-auto">
                </div>

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    <!-- Header -->
                    <div class="px-8 pt-8 pb-4 text-center border-b border-slate-100">
                        <div
                            class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 14.094A5.973 5.973 0 004 17v1H1v-1a3 3 0 013.75-2.906z" />
                            </svg>
                            Agent Umum
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Buat Akun Baru</h2>
                        <p class="text-slate-500 text-sm mt-1">Lengkapi data dan kode referral Anda</p>
                    </div>

                    <!-- Form -->
                    <div class="p-8">

                        {{-- Alerts --}}
                        @if(session('success'))
                            <div
                                class="mb-5 flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div
                                class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('agent-luar.register.store') }}" method="POST" class="space-y-5"
                            id="registerForm">
                            @csrf

                            <!-- Kode Referral — Letakkan paling atas agar paling mencolok -->
                            <div class="badge-referral border rounded-2xl p-4">
                                <label class="block text-sm font-semibold text-blue-900 mb-1.5">
                                    🔑 Kode Referral Agent
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode_referral_dipakai"
                                    value="{{ old('kode_referral_dipakai') }}" placeholder="Contoh: REF-ABCD1234"
                                    maxlength="20"
                                    class="w-full px-4 py-3 rounded-xl border border-blue-200 bg-white text-slate-800 font-mono tracking-wider text-sm input-focus uppercase"
                                    oninput="this.value = this.value.toUpperCase()">
                                <p class="text-xs text-blue-600 mt-1.5">Minta kode ini kepada Agent Internal yang
                                    mengundang Anda.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Nama lengkap sesuai KTP"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm input-focus">
                                </div>



                                <!-- WhatsApp -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Nomor WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm input-focus">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        placeholder="nama@email.com"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm input-focus">
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password"
                                            placeholder="Min. 6 karakter"
                                            class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 text-sm input-focus">
                                        <button type="button" onclick="togglePass('password','eye1')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                            <svg id="eye1" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Ulangi password"
                                            class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 text-sm input-focus">
                                        <button type="button" onclick="togglePass('password_confirmation','eye2')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                            <svg id="eye2" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" id="submitBtn"
                                class="btn-primary w-full text-white font-semibold py-3.5 rounded-xl text-sm">
                                Daftar Sebagai Agent Umum
                            </button>

                        </form>

                        <!-- Login link -->
                        <div class="mt-6 text-center border-t border-slate-100 pt-5">
                            <p class="text-slate-500 text-sm">
                                Sudah punya akun?
                                <a href="{{ route('agent-luar.login') }}"
                                    class="text-[#018FD7] font-semibold hover:underline ml-1">
                                    Masuk
                                </a>
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }
    </script>

</body>

</html>