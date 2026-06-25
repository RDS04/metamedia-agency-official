<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Agen Mahasiswa</title>
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
                    Reset kata sandi Anda dengan aman menggunakan verifikasi OTP yang dikirim langsung ke email Anda.
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
                            @if(session('password_reset_otp_verified'))
                                Reset Password
                            @elseif(session('pending_password_reset'))
                                Verifikasi OTP
                            @else
                                Lupa Password
                            @endif
                        </h2>

                        <p class="text-gray-500 mt-2">
                            @if(session('password_reset_otp_verified'))
                                Masukkan password baru Anda untuk akun Anda.
                            @elseif(session('pending_password_reset'))
                                Masukkan 6 digit kode OTP yang dikirim ke email Anda.
                            @else
                                Masukkan email terdaftar Anda untuk mengirim kode OTP reset password.
                            @endif
                        </p>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- State Switcher -->
                    @if(session('password_reset_otp_verified'))
                        <!-- STEP 3: Reset Password Form -->
                        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" required
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">
                                    <button type="button" onclick="togglePasswordVisibility('password', 'eyeIconPassword')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg id="eyeIconPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru" required
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eyeIconPasswordConfirm')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg id="eyeIconPasswordConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-[#018FD7] hover:bg-[#0077b5] text-white py-3 rounded-xl font-semibold transition">
                                Simpan Password Baru
                            </button>
                        </form>

                    @elseif(session('pending_password_reset'))
                        <!-- STEP 2: Verify OTP Form -->
                        <div class="mb-4 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-900 text-center">
                            Email tujuan: <span class="font-semibold">{{ session('pending_password_reset.email') }}</span>
                        </div>

                        <form action="{{ route('password.verify-otp') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Kode OTP
                                </label>
                                <input type="text" name="otp" maxlength="6" inputmode="numeric" required
                                    placeholder="Masukkan 6 digit OTP" autocomplete="one-time-code"
                                    class="w-full px-4 py-3 text-center tracking-[0.4em] font-semibold text-lg border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">
                            </div>

                            <button type="submit"
                                class="w-full bg-[#018FD7] hover:bg-[#0077b5] text-white py-3 rounded-xl font-semibold transition">
                                Verifikasi OTP
                            </button>
                        </form>

                        <!-- Resend OTP -->
                        <form action="{{ route('password.resend-otp') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit"
                                class="w-full border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-3 rounded-xl transition text-sm">
                                Kirim Ulang OTP
                            </button>
                        </form>

                        <!-- Cancel and Change Email -->
                        <form action="{{ route('password.cancel') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit"
                                class="w-full text-[#018FD7] hover:text-[#0077b5] font-semibold py-2 rounded-xl transition text-sm">
                                Ubah Email / Batal
                            </button>
                        </form>

                    @else
                        <!-- STEP 1: Email Request Form -->
                        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Alamat Email
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#018FD7] outline-none">
                            </div>

                            <button type="submit"
                                class="w-full bg-[#018FD7] hover:bg-[#0077b5] text-white py-3 rounded-xl font-semibold transition">
                                Kirim Kode OTP
                            </button>
                        </form>

                        <!-- Back to Login Link -->
                        <div class="text-center mt-6">
                            <p class="text-sm text-gray-600">
                                Kembali ke halaman
                                <a href="{{ route('auth.login') }}" class="text-[#018FD7] font-semibold hover:underline">
                                    Login
                                </a>
                            </p>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

    <x-lilin />

    <script>
        function togglePasswordVisibility(inputId, iconId) {
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
