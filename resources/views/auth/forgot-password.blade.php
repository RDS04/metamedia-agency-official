<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — PMB Metamedia</title>
    <meta name="description" content="Reset password akun PMB Metamedia dengan verifikasi kode OTP.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-left { background: linear-gradient(135deg, #001B44 0%, #013A7A 60%, #018FD7 100%); }
        .input-focus { transition: all .2s; }
        .input-focus:focus { border-color: #018FD7; box-shadow: 0 0 0 4px rgba(1,143,215,.12); outline: none; }
        .btn-primary { background: linear-gradient(135deg, #018FD7, #0073b1); transition: all .2s; }
        .btn-primary:hover { background: linear-gradient(135deg, #0073b1, #005f94); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(1,143,215,.35); }
    </style>
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- LEFT SIDE -->
        <div class="hidden lg:flex lg:w-5/12 relative overflow-hidden gradient-left">
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#grid)"/>
                </svg>
            </div>
            <img src="{{ asset('storage/gedungMetamedia.webp') }}" alt="Gedung Kampus"
                class="absolute inset-0 w-full h-full object-cover opacity-20">

            <div class="relative z-10 flex flex-col justify-center px-14 text-white">
                <div class="mb-8">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo Metamedia" class="h-14 w-auto brightness-0 invert opacity-90">
                </div>
                <h1 class="text-4xl font-extrabold leading-tight mb-4">
                    Reset Password<br>
                    <span class="text-[#7dd3fc]">PMB Metamedia</span>
                </h1>
                <p class="text-blue-200 leading-relaxed max-w-sm text-sm">
                    Reset kata sandi Anda dengan aman menggunakan verifikasi kode OTP yang dikirimkan langsung ke email Anda.
                </p>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex-1 flex items-center justify-center p-6 bg-slate-50">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="flex justify-center mb-6 lg:hidden">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-16 w-auto">
                </div>

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    <!-- Header -->
                    <div class="px-8 pt-8 pb-5 text-center border-b border-slate-100">
                        <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            Keamanan Akun
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">
                            @if(session('password_reset_otp_verified'))
                                Reset Password
                            @elseif(session('pending_password_reset'))
                                Verifikasi OTP
                            @else
                                Lupa Password
                            @endif
                        </h2>
                        <p class="text-slate-500 text-sm mt-1">
                            @if(session('password_reset_otp_verified'))
                                Masukkan password baru Anda
                            @elseif(session('pending_password_reset'))
                                Masukkan 6 digit kode OTP yang dikirim ke email
                            @else
                                Masukkan email yang terdaftar untuk menerima OTP
                            @endif
                        </p>
                    </div>

                    <div class="p-8">

                        {{-- Alerts --}}
                        @if(session('success'))
                            <div class="mb-5 flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- STATE SWITCHER -->
                        @if(session('password_reset_otp_verified'))
                            <!-- STEP 3: Reset Password Form -->
                            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Password Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" required
                                            class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 text-sm input-focus">
                                        <button type="button" onclick="togglePass('password', 'eyeIcon1')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                            <svg id="eyeIcon1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Konfirmasi Password Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru" required
                                            class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 text-sm input-focus">
                                        <button type="button" onclick="togglePass('password_confirmation', 'eyeIcon2')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                            <svg id="eyeIcon2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary w-full text-white py-3.5 rounded-xl font-semibold text-sm">
                                    Simpan Password Baru
                                </button>
                            </form>

                        @elseif(session('pending_password_reset'))
                            <!-- STEP 2: Verify OTP Form -->
                            <div class="mb-5 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-900 text-center flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>OTP dikirim ke: <strong class="font-semibold text-blue-950">{{ session('pending_password_reset.email') }}</strong></span>
                            </div>

                            <form action="{{ route('password.verify-otp') }}" method="POST" class="space-y-5">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5 text-center">
                                        Masukkan Kode OTP (6 Digit)
                                    </label>
                                    <input type="text" name="otp" maxlength="6" inputmode="numeric" required
                                        placeholder="123456" autocomplete="one-time-code"
                                        class="w-full px-4 py-3.5 text-center tracking-[0.5em] font-bold text-xl rounded-xl border border-slate-200 text-slate-800 input-focus">
                                </div>

                                <button type="submit" class="btn-primary w-full text-white py-3.5 rounded-xl font-semibold text-sm">
                                    Verifikasi OTP
                                </button>
                            </form>

                            <div class="mt-4 flex flex-col gap-2">
                                <!-- Resend OTP -->
                                <form action="{{ route('password.resend-otp') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 rounded-xl transition text-xs">
                                        Kirim Ulang Kode OTP
                                    </button>
                                </form>

                                <!-- Cancel / Change Email -->
                                <form action="{{ route('password.cancel') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-slate-500 hover:text-slate-800 font-semibold py-2 rounded-xl transition text-xs">
                                        ← Ganti Email / Batal
                                    </button>
                                </form>
                            </div>

                        @else
                            <!-- STEP 1: Email Request Form -->
                            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Email Terdaftar
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm input-focus">
                                </div>

                                <button type="submit" class="btn-primary w-full text-white py-3.5 rounded-xl font-semibold text-sm">
                                    Kirim Kode OTP
                                </button>
                            </form>

                            <!-- Back to Login Link -->
                            <div class="text-center mt-6">
                                <p class="text-sm text-slate-600">
                                    Ingat password Anda?
                                    <a href="{{ route('auth.login') }}" class="text-[#018FD7] font-semibold hover:underline ml-1">
                                        Kembali ke Login
                                    </a>
                                </p>
                            </div>
                        @endif

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
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>

</body>

</html>
