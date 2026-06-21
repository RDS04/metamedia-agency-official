<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent PMB Metamedia 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            950: '#060D1A',
                            900: '#0A1628',
                            800: '#0D1F38',
                            700: '#1A2E4A',
                        },
                        brand: {
                            DEFAULT: '#018FD7',
                            dark: '#0179b8',
                            light: '#E6F4FC',
                        },
                        gold: {
                            DEFAULT: '#F5A623',
                            dark: '#B8720A',
                            light: '#FEF3DC',
                        }
                    },
                    fontFamily: {
                        sans: ['Rubik', 'Poppins', 'Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <style>
        * {
            scroll-behavior: smooth;
        }

        .tier-active {
            border: 2px solid #018FD7;
        }

        input[type=range] {
            -webkit-appearance: none;
            height: 4px;
            border-radius: 2px;
            background: #1A2E4A;
            outline: none;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #018FD7;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #018FD7;
        }

        /* ===== SCROLL ANIMATION VARIANTS ===== */
        .scroll-animate {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform, opacity;
        }

        .scroll-animate.visible {
            opacity: 1;
            transform: translate(0, 0) !important;
        }

        .from-left {
            transform: translateX(-60px);
        }

        .from-right {
            transform: translateX(60px);
        }

        .from-top {
            transform: translateY(-60px);
        }

        .from-bottom {
            transform: translateY(60px);
        }

        .from-random-1 {
            transform: translate(-40px, 30px) scale(0.9);
        }

        .from-random-2 {
            transform: translate(40px, -30px) scale(0.9);
        }

        .from-random-3 {
            transform: translate(-30px, -40px) scale(0.9);
        }

        .from-random-4 {
            transform: translate(30px, 40px) scale(0.9);
        }

        .stagger-item {
            opacity: 0;
            transition: opacity 0.7s ease, transform 0.7s ease;
            will-change: transform, opacity;
        }

        .stagger-item.visible {
            opacity: 1;
            transform: translate(0, 0) !important;
        }

        .stagger-item.delay-1 {
            transition-delay: 0.08s;
        }

        .stagger-item.delay-2 {
            transition-delay: 0.16s;
        }

        .stagger-item.delay-3 {
            transition-delay: 0.24s;
        }

        .stagger-item.delay-4 {
            transition-delay: 0.32s;
        }

        .nav-item {
            opacity: 0;
            transform: translateY(-12px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .nav-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== ANIMASI FONT MASUK ===== */
        .hero-title {
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.3s;
        }

        .hero-subtitle {
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.6s;
        }

        .hero-cta {
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.9s;
        }

        .hero-badge {
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.1s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .highlight-text {
            display: inline-block;
            position: relative;
        }

        .highlight-text::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 0;
            height: 3px;
            background: #F5A623;
            animation: underlineExpand 1.2s ease forwards;
            animation-delay: 0.8s;
        }

        @keyframes underlineExpand {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        .hero-badge {
            animation: pulseScale 0.8s ease forwards;
            animation-delay: 0.1s;
        }

        @keyframes pulseScale {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .counter-number {
            display: inline-block;
        }

        /* ===== STYLE UNTUK RATING BINTANG ===== */
        .rating-stars {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .rating-stars .star {
            font-size: 32px;
            cursor: pointer;
            color: #4a5568;
            transition: all 0.2s ease;
            user-select: none;
        }

        .rating-stars .star:hover,
        .rating-stars .star.active {
            color: #F5A623;
            transform: scale(1.15);
        }

        .rating-stars .star:hover~.star {
            color: #4a5568;
        }

        /* Checkbox & Radio custom */
        .feature-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #4a5568;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            flex-shrink: 0;
        }

        .feature-checkbox:checked {
            background: #018FD7;
            border-color: #018FD7;
        }

        .feature-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        /* Form input focus */
        .form-input:focus {
            border-color: #018FD7;
            box-shadow: 0 0 0 3px rgba(1, 143, 215, 0.15);
            outline: none;
        }

        /* Textarea */
        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .rating-stars .star {
                font-size: 28px;
            }
        }
    </style>
</head>

<body class="bg-white font-sans antialiased">

    <!-- ===== NAVBAR ===== -->
    <nav class="bg-navy-950 border-b border-navy-700 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-5 flex items-center justify-between h-14">

            <div class="flex items-center gap-2 nav-item visible">
                <i class="ti ti-school text-brand text-xl"></i>
                <span class="text-white font-semibold text-sm tracking-wide">Agent PMB <span
                        class="text-brand">Metamedia</span></span>
            </div>

            <div class="hidden md:flex items-center gap-7">
                <a href="#keuntungan"
                    class="nav-item text-slate-400 hover:text-white text-sm transition-colors">Keuntungan</a>
                <a href="#bonus" class="nav-item text-slate-400 hover:text-white text-sm transition-colors">Bonus</a>
                <a href="{{ route('auth.register') }}"
                    class="nav-item text-slate-400 hover:text-white text-sm transition-colors">Cara Daftar</a>
            </div>

            <div class="flex items-center gap-3">
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}"
                        class="nav-item bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('auth.login') }}"
                        class="nav-item text-slate-300 hover:text-white text-sm font-medium px-4 py-2 rounded-lg border border-navy-700 hover:border-brand transition-colors">
                        Login
                    </a>

                    <a href="{{ route('auth.register') }}"
                        class="nav-item bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                        Register
                    </a>
                @endif
            </div>

        </div>
    </nav>


    <!-- ===== HERO ===== -->
    <section class="bg-navy-900 pt-20 pb-20 px-5 relative overflow-hidden">

        <!-- Background gradient decoration -->
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-brand opacity-5 rounded-full blur-3xl pointer-events-none">
        </div>
        <div
            class="absolute bottom-10 right-0 w-[400px] h-[400px] bg-brand opacity-3 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">

                <!-- Left: Image Gedung Metamedia -->
                <div class="scroll-animate from-left">
                    <div class="relative">
                        <!-- Frame dengan shadow dan border blend ke background -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-brand/10 to-gold/10 rounded-2xl blur-xl opacity-50 -z-10">
                        </div>
                        <img src="{{ asset('storage/gedungMetamedia.webp') }}" alt="Gedung Metamedia"
                            class="w-full h-auto rounded-2xl shadow-lg border border-brand/20 object-cover opacity-75 hover:opacity-90 transition-opacity duration-300">

                        <!-- Overlay badge -->
                        <div
                            class="absolute bottom-4 left-4 bg-navy-950/80 backdrop-blur-md border border-brand/40 rounded-xl px-4 py-3">
                            <p class="text-gold text-sm font-bold">Metamedia</p>
                            <p class="text-slate-300 text-xs">Institusi Pendidikan Terpercaya</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Content Text -->
                <div class="scroll-animate from-right text-left md:text-left">
                    <div
                        class="hero-badge inline-flex items-center gap-2 bg-gold/10 border border-gold/30 text-gold text-xs font-medium px-4 py-1.5 rounded-full mb-6">
                        <i class="ti ti-sparkles text-sm"></i>
                        Program Agent Resmi Metamedia 2026
                    </div>

                    <h1 class="hero-title text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                        Bantu Calon Mahasiswa,<br>
                        <span class="text-gold highlight-text">Dapatkan Bonus Tunai</span>
                    </h1>

                    <p class="hero-subtitle text-slate-400 text-base md:text-lg mb-8 leading-relaxed">
                        Jadilah Agent PMB Metamedia. Setiap mahasiswa yang berhasil kamu rekomendasikan, kamu dapat
                        komisi langsung ke rekeningmu.
                    </p>

                    <div class="hero-cta flex flex-col sm:flex-row gap-3 mb-8">
                        <a href="#daftar"
                            class="bg-brand hover:bg-brand-dark text-white font-semibold px-8 py-3.5 rounded-xl transition-colors text-sm text-center">
                            Daftar Jadi Agent Sekarang
                        </a>
                        <a href="#bonus"
                            class="border border-navy-700 hover:border-brand text-slate-400 hover:text-brand px-8 py-3.5 rounded-xl transition-colors text-sm text-center">
                            Lihat Struktur Bonus
                        </a>
                    </div>

                    <div class="flex items-center gap-6 pt-4 border-t border-navy-700">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-check text-brand text-lg"></i>
                            <p class="text-slate-400 text-xs">Gratis mendaftar</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="ti ti-check text-brand text-lg"></i>
                            <p class="text-slate-400 text-xs">Tidak ada target minimum</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="ti ti-check text-brand text-lg"></i>
                            <p class="text-slate-400 text-xs">Bonus langsung cair</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>


    <!-- ===== STATS BAR ===== -->
    <section class="bg-brand py-5">
        <div class="max-w-6xl mx-auto px-5 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="scroll-animate from-top">
                <div class="text-white text-2xl font-bold">
                    <span class="counter-number" data-target="12000" data-suffix="+">0</span>
                </div>
                <div class="text-blue-100 text-xs mt-0.5">Mahasiswa Aktif</div>
            </div>
            <div class="scroll-animate from-bottom">
                <div class="text-white text-2xl font-bold">
                    <span class="counter-number" data-target="25">0</span>
                </div>
                <div class="text-blue-100 text-xs mt-0.5">Program Studi</div>
            </div>
            <div class="scroll-animate from-left">
                <div class="text-white text-2xl font-bold">
                    <span class="counter-number" data-target="500" data-suffix="+">0</span>
                </div>
                <div class="text-blue-100 text-xs mt-0.5">Dosen</div>
            </div>
            <div class="scroll-animate from-right">
                <div class="text-white text-2xl font-bold">
                    <span class="counter-number" data-target="20000" data-suffix="+">0</span>
                </div>
                <div class="text-blue-100 text-xs mt-0.5">Alumni</div>
            </div>
        </div>
    </section>


    <!-- ===== KEUNTUNGAN ===== -->
    <section id="keuntungan" class="bg-slate-50 py-16 px-5">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-10 scroll-animate from-left">
                <p class="text-brand text-xs font-semibold uppercase tracking-widest mb-2">Keuntungan Agent</p>
                <h2 class="text-3xl font-bold text-slate-900 mb-3">Kenapa Jadi Agent Metamedia?</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                    Tidak perlu pengalaman khusus. Cukup punya kenalan calon mahasiswa dan semangat untuk membantu.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <div class="bg-white border border-slate-200 rounded-2xl p-6 stagger-item from-left delay-1">
                    <div class="w-10 h-10 bg-brand-light rounded-xl flex items-center justify-center mb-4">
                        <i class="ti ti-cash text-brand text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Bonus Langsung Cair</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Komisi ditransfer ke rekeningmu setelah mahasiswa
                        resmi diterima dan melakukan pembayaran.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 stagger-item from-right delay-2">
                    <div class="w-10 h-10 bg-brand-light rounded-xl flex items-center justify-center mb-4">
                        <i class="ti ti-trending-up text-brand text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Makin Banyak, Makin Besar</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Semakin banyak referral yang masuk, semakin tinggi
                        tier dan bonus per mahasiswamu.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 stagger-item from-top delay-3">
                    <div class="w-10 h-10 bg-brand-light rounded-xl flex items-center justify-center mb-4">
                        <i class="ti ti-device-mobile text-brand text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Dashboard Real-time</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Pantau progress referral dan status komisi kapan
                        saja dan di mana saja lewat dashboard online.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 stagger-item from-bottom delay-4">
                    <div class="w-10 h-10 bg-brand-light rounded-xl flex items-center justify-center mb-4">
                        <i class="ti ti-shield-check text-brand text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Program Resmi & Terpercaya</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Program agent resmi dari institusi pendidikan yang
                        telah terakreditasi secara nasional.</p>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== BONUS TIERS + KALKULATOR ===== -->
    <section id="bonus" class="bg-white py-16 px-5">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-10 scroll-animate from-right">
                <p class="text-brand text-xs font-semibold uppercase tracking-widest mb-2">Struktur Bonus</p>
                <h2 class="text-3xl font-bold text-slate-900 mb-3">Simulasi Penghasilanmu</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                    Geser slider di bawah untuk melihat estimasi bonus berdasarkan jumlah mahasiswa yang berhasil kamu
                    rekrut.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-start">

                <div class="scroll-animate from-left">
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-200">
                            <p class="text-sm font-semibold text-slate-700">Level Bonus Agent</p>
                        </div>

                        <div id="tier-starter"
                            class="flex items-center justify-between px-5 py-4 border-b border-slate-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-blue-200"></div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Starter</p>
                                    <p class="text-xs text-slate-400">1 – 5 mahasiswa</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800">Rp 250.000</p>
                                <p class="text-xs text-slate-400">per mahasiswa</p>
                            </div>
                        </div>

                        <div id="tier-silver"
                            class="flex items-center justify-between px-5 py-4 border-b border-slate-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-brand"></div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Silver</p>
                                    <p class="text-xs text-slate-400">6 – 15 mahasiswa</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800">Rp 400.000</p>
                                <p class="text-xs text-slate-400">per mahasiswa</p>
                            </div>
                        </div>

                        <div id="tier-gold"
                            class="flex items-center justify-between px-5 py-4 border-b border-slate-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-gold"></div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Gold</p>
                                    <p class="text-xs text-slate-400">16 – 30 mahasiswa</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800">Rp 600.000</p>
                                <p class="text-xs text-slate-400">per mahasiswa</p>
                            </div>
                        </div>

                        <div id="tier-platinum" class="flex items-center justify-between px-5 py-4 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Platinum</p>
                                    <p class="text-xs text-slate-400">31+ mahasiswa</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gold-dark">Rp 850.000</p>
                                <p class="text-xs text-slate-400">per mahasiswa</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="scroll-animate from-right">
                    <div class="bg-navy-900 rounded-2xl p-6">
                        <div class="flex items-center gap-2 mb-5">
                            <i class="ti ti-calculator text-brand text-lg"></i>
                            <p class="text-white text-sm font-semibold">Kalkulator Bonus Agent</p>
                        </div>

                        <div class="mb-5">
                            <div class="flex justify-between mb-2">
                                <label class="text-slate-400 text-xs">Jumlah mahasiswa yang kamu rekrut</label>
                                <span class="text-white text-xs font-semibold" id="mhsVal">10</span>
                            </div>
                            <input type="range" id="mhsSlider" min="1" max="50" value="10" step="1" class="w-full"
                                oninput="calcBonus()">
                            <div class="flex justify-between mt-1">
                                <span class="text-slate-600 text-xs">1</span>
                                <span class="text-slate-600 text-xs">50</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div class="bg-navy-800 rounded-xl p-4">
                                <p class="text-slate-500 text-xs mb-1">Tier kamu</p>
                                <p class="text-white text-lg font-bold" id="tierLabel">Silver</p>
                            </div>
                            <div class="bg-navy-800 rounded-xl p-4">
                                <p class="text-slate-500 text-xs mb-1">Bonus per mahasiswa</p>
                                <p class="text-white text-lg font-bold" id="perMhs">Rp 400rb</p>
                            </div>
                        </div>

                        <div class="bg-gold/10 border border-gold/30 rounded-xl p-4 text-center">
                            <p class="text-slate-400 text-xs mb-1">Estimasi total bonus kamu</p>
                            <p class="text-gold text-3xl font-bold" id="totalBonus">Rp 4.000.000</p>
                            <p class="text-slate-500 text-xs mt-1">*estimasi, dapat berbeda sesuai kebijakan</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== CARA DAFTAR ===== -->
    <section id="cara-daftar" class="bg-slate-50 py-16 px-5">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-10 scroll-animate from-random-1">
                <p class="text-brand text-xs font-semibold uppercase tracking-widest mb-2">Cara Bergabung</p>
                <h2 class="text-3xl font-bold text-slate-900 mb-3">4 Langkah Jadi Agent</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                    Proses pendaftaran cepat dan mudah, tidak memerlukan dokumen yang rumit.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <div
                    class="bg-white border border-slate-200 rounded-2xl p-6 text-center stagger-item from-random-2 delay-1">
                    <div
                        class="w-10 h-10 bg-navy-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-sm font-bold">
                        1</div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Daftar Akun</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Isi form pendaftaran online, gratis dan hanya
                        butuh 2 menit untuk menyelesaikannya.</p>
                </div>

                <div
                    class="bg-white border border-slate-200 rounded-2xl p-6 text-center stagger-item from-random-3 delay-2">
                    <div
                        class="w-10 h-10 bg-navy-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-sm font-bold">
                        2</div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Dapatkan Kode Referral</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Terima kode referral unikmu setelah akun berhasil
                        diverifikasi oleh tim kami.</p>
                </div>

                <div
                    class="bg-white border border-slate-200 rounded-2xl p-6 text-center stagger-item from-random-4 delay-3">
                    <div
                        class="w-10 h-10 bg-navy-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-sm font-bold">
                        3</div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Rekomendasikan</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Bagikan info dan kode referralmu ke calon
                        mahasiswa yang kamu kenal.</p>
                </div>

                <div
                    class="bg-white border border-slate-200 rounded-2xl p-6 text-center stagger-item from-random-1 delay-4">
                    <div
                        class="w-10 h-10 bg-gold text-white rounded-full flex items-center justify-center mx-auto mb-4 text-sm font-bold">
                        4</div>
                    <h3 class="font-semibold text-slate-800 text-sm mb-2">Terima Bonus 🎉</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Bonus langsung ditransfer setelah pendaftaran
                        mahasiswa dikonfirmasi dan lunas.</p>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== TESTIMONI ===== -->
    <section class="bg-white py-16 px-5">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-10 scroll-animate from-bottom">
                <p class="text-brand text-xs font-semibold uppercase tracking-widest mb-2">Testimoni</p>
                <h2 class="text-3xl font-bold text-slate-900 mb-3">Kata Mereka yang Sudah Bergabung</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-5">

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 stagger-item from-left delay-1">
                    <div class="flex items-center gap-1 mb-3">
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                    </div>
                    <p class="text-slate-600 text-xs leading-relaxed mb-4">"Dalam 2 bulan pertama saya sudah berhasil
                        membawa 12 mahasiswa. Bonusnya langsung cair ke rekening, prosesnya mudah banget!"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-light flex items-center justify-center text-brand text-xs font-semibold">
                            RA</div>
                        <div>
                            <p class="text-slate-800 text-xs font-semibold">Rizky Aditya</p>
                            <p class="text-slate-400 text-xs">Agent Silver · Surabaya</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 stagger-item from-right delay-2">
                    <div class="flex items-center gap-1 mb-3">
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                    </div>
                    <p class="text-slate-600 text-xs leading-relaxed mb-4">"Alhamdulillah sudah mencapai tier Gold.
                        Penghasilan tambahan ini sangat membantu biaya kuliah saya sehari-hari."</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-gold-light flex items-center justify-center text-gold-dark text-xs font-semibold">
                            DP</div>
                        <div>
                            <p class="text-slate-800 text-xs font-semibold">Dinda Putri</p>
                            <p class="text-slate-400 text-xs">Agent Gold · Bandung</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 stagger-item from-random-4 delay-3">
                    <div class="flex items-center gap-1 mb-3">
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                        <i class="ti ti-star-filled text-gold text-sm"></i>
                    </div>
                    <p class="text-slate-600 text-xs leading-relaxed mb-4">"Saya rekomendasikan ke komunitas saya.
                        Sekarang sudah Platinum dan dapat lebih dari Rp 20 juta dari program ini. Worth it banget!"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold">
                            MH</div>
                        <div>
                            <p class="text-slate-800 text-xs font-semibold">Muhamad Haris</p>
                            <p class="text-slate-400 text-xs">Agent Platinum · Jakarta</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== CTA BOTTOM - FORM KEPUASAN AGENT ===== -->
    <section id="daftar" class="bg-navy-900 py-16 px-5 relative overflow-hidden">

        <div
            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[500px] h-[200px] bg-brand opacity-5 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-3xl mx-auto relative scroll-animate from-random-2">

            <!-- Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center gap-2 bg-gold/10 border border-gold/30 text-gold text-xs font-medium px-4 py-1.5 rounded-full mb-4">
                    <i class="ti ti-heart-filled text-sm"></i>
                    Kepuasan Agent
                </div>
                <h2 class="text-3xl font-bold text-white mb-3">Bagaimana Kepuasanmu dengan Fitur Agent Ini?</h2>
                <p class="text-slate-400 text-sm max-w-lg mx-auto leading-relaxed">
                    Kami sangat menghargai pendapatmu! Berikan penilaian dan masukan untuk terus meningkatkan program
                    Agent PMB Metamedia.
                </p>
            </div>

            <!-- Form -->
            <div class="bg-navy-800 border border-navy-700 rounded-2xl p-6 md:p-8">

                <form id="surveyForm" onsubmit="handleSurvey(event)" data-loading-ignore="true" class="space-y-5">

                    <!-- 1. Nama Lengkap -->
                    <div>
                        <label class="text-sm text-slate-300 font-medium mb-1.5 block">
                            <i class="ti ti-user text-brand text-sm mr-1"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" placeholder="Masukkan nama lengkap kamu" required
                            class="form-input w-full bg-navy-900 border border-navy-700 text-white text-sm placeholder-slate-600 px-4 py-3 rounded-xl transition-colors">
                    </div>

                    <!-- 2. Email -->
                    <div>
                        <label class="text-sm text-slate-300 font-medium mb-1.5 block">
                            <i class="ti ti-mail text-brand text-sm mr-1"></i>
                            Email
                        </label>
                        <input type="email" placeholder="email@kamu.com" required
                            class="form-input w-full bg-navy-900 border border-navy-700 text-white text-sm placeholder-slate-600 px-4 py-3 rounded-xl transition-colors">
                    </div>

                    <!-- 3. Rating Bintang -->
                    <div>
                        <label class="text-sm text-slate-300 font-medium mb-2 block">
                            <i class="ti ti-star text-brand text-sm mr-1"></i>
                            Seberapa puas kamu dengan program Agent PMB Metamedia?
                        </label>
                        <div class="rating-stars" id="ratingStars">
                            <span class="star" data-value="1" onclick="setRating(1)">⭐</span>
                            <span class="star" data-value="2" onclick="setRating(2)">⭐</span>
                            <span class="star" data-value="3" onclick="setRating(3)">⭐</span>
                            <span class="star" data-value="4" onclick="setRating(4)">⭐</span>
                            <span class="star" data-value="5" onclick="setRating(5)">⭐</span>
                        </div>
                        <input type="hidden" id="ratingValue" value="0" required>
                        <p class="text-slate-500 text-xs mt-2" id="ratingLabel">Klik bintang untuk memberi penilaian</p>
                    </div>

                    <!-- 4. Fitur Favorit (Checkbox) -->
                    <div>
                        <label class="text-sm text-slate-300 font-medium mb-2 block">
                            <i class="ti ti-thumb-up text-brand text-sm mr-1"></i>
                            Fitur apa yang paling kamu sukai? (boleh pilih lebih dari satu)
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label
                                class="flex items-center gap-3 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="checkbox" class="feature-checkbox" value="Bonus Langsung Cair">
                                <span>Bonus Langsung Cair</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="checkbox" class="feature-checkbox" value="Dashboard Real-time">
                                <span>Dashboard Real-time</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="checkbox" class="feature-checkbox" value="Struktur Bonus Tier">
                                <span>Struktur Bonus Tier</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="checkbox" class="feature-checkbox" value="Kalkulator Simulasi">
                                <span>Kalkulator Simulasi</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="checkbox" class="feature-checkbox" value="Testimoni Agent">
                                <span>Testimoni Agent Lain</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="checkbox" class="feature-checkbox" value="Lainnya">
                                <span>Lainnya</span>
                            </label>
                        </div>
                    </div>

                    <!-- 5. Saran & Masukan -->
                    <div>
                        <label class="text-sm text-slate-300 font-medium mb-1.5 block">
                            <i class="ti ti-message-circle text-brand text-sm mr-1"></i>
                            Saran atau masukan untuk pengembangan fitur Agent
                        </label>
                        <textarea placeholder="Tulis saran atau masukanmu di sini..."
                            class="form-textarea w-full bg-navy-900 border border-navy-700 text-white text-sm placeholder-slate-600 px-4 py-3 rounded-xl transition-colors"></textarea>
                    </div>

                    <!-- 6. Rekomendasi -->
                    <div>
                        <label class="text-sm text-slate-300 font-medium mb-2 block">
                            <i class="ti ti-share text-brand text-sm mr-1"></i>
                            Apakah kamu akan merekomendasikan program ini ke teman?
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <label
                                class="flex items-center gap-2 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="radio" name="rekomendasi" value="Ya, pasti!" class="accent-brand w-4 h-4">
                                <span>Ya, pasti!</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="radio" name="rekomendasi" value="Mungkin" class="accent-brand w-4 h-4">
                                <span>Mungkin</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="radio" name="rekomendasi" value="Belum tahu" class="accent-brand w-4 h-4">
                                <span>Belum tahu</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-slate-300 text-sm cursor-pointer hover:text-white transition-colors">
                                <input type="radio" name="rekomendasi" value="Tidak" class="accent-brand w-4 h-4">
                                <span>Tidak</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-brand hover:bg-brand-dark text-white font-semibold py-3.5 rounded-xl transition-all duration-300 text-sm hover:scale-[1.02] active:scale-[0.98]">
                        <i class="ti ti-send mr-2"></i>
                        Kirim Penilaian
                    </button>

                    <p class="text-center text-slate-600 text-xs mt-3">
                        <i class="ti ti-lock text-xs mr-1"></i>
                        Data kamu aman dan tidak akan disebarluaskan
                    </p>

                </form>

            </div>

        </div>
    </section>


    <!-- ===== FOOTER ===== -->
    <footer class="bg-navy-950 border-t border-navy-700 py-8 px-5">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="ti ti-school text-brand text-lg"></i>
                <span class="text-white text-sm font-semibold">Agent PMB <span
                        class="text-brand">Metamedia</span></span>
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Kebijakan Privasi</a>
                <a href="#" class="text-slate-500 hover:text-slate-300 text-xs transition-colors">Kontak</a>
            </div>
            <p class="text-slate-600 text-xs">© 2026 Metamedia. All Rights Reserved.</p>
        </div>
    </footer>


    <!-- ===== SCRIPTS ===== -->
    <script>
        // Kalkulator bonus
        function calcBonus() {
            const n = parseInt(document.getElementById('mhsSlider').value);
            document.getElementById('mhsVal').textContent = n;

            let tier, rate, tierId;
            if (n <= 5) { tier = 'Starter'; rate = 250000; tierId = 'starter'; }
            else if (n <= 15) { tier = 'Silver'; rate = 400000; tierId = 'silver'; }
            else if (n <= 30) { tier = 'Gold'; rate = 600000; tierId = 'gold'; }
            else { tier = 'Platinum'; rate = 850000; tierId = 'platinum'; }

            const total = n * rate;

            document.getElementById('tierLabel').textContent = tier;
            document.getElementById('perMhs').textContent = 'Rp ' + (rate / 1000) + 'rb';
            document.getElementById('totalBonus').textContent = 'Rp ' + total.toLocaleString('id-ID');

            ['starter', 'silver', 'gold', 'platinum'].forEach(t => {
                const el = document.getElementById('tier-' + t);
                if (t === tierId) {
                    el.classList.add('bg-brand-light');
                } else {
                    el.classList.remove('bg-brand-light');
                }
            });
        }

        // ===== RATING BINTANG =====
        let selectedRating = 0;

        function setRating(value) {
            selectedRating = value;
            document.getElementById('ratingValue').value = value;

            const stars = document.querySelectorAll('.rating-stars .star');
            stars.forEach((star, index) => {
                if (index < value) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });

            const labels = ['', 'Sangat Tidak Puas', 'Tidak Puas', 'Cukup Puas', 'Puas', 'Sangat Puas'];
            document.getElementById('ratingLabel').textContent = labels[value] || 'Klik bintang untuk memberi penilaian';
        }

        // Hover effect untuk bintang
        document.querySelectorAll('.rating-stars .star').forEach(star => {
            star.addEventListener('mouseenter', function () {
                const value = parseInt(this.dataset.value);
                const stars = document.querySelectorAll('.rating-stars .star');
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.style.color = '#F5A623';
                    } else {
                        s.style.color = '#4a5568';
                    }
                });
            });
            star.addEventListener('mouseleave', function () {
                const stars = document.querySelectorAll('.rating-stars .star');
                stars.forEach((s, index) => {
                    if (index < selectedRating) {
                        s.style.color = '#F5A623';
                    } else {
                        s.style.color = '#4a5568';
                    }
                });
            });
        });

        // ===== HANDLE SURVEY SUBMIT =====
        function handleSurvey(e) {
            e.preventDefault();

            // Ambil data dari form
            const form = e.target;
            const nama = form.querySelector('input[type="text"]').value;
            const email = form.querySelector('input[type="email"]').value;
            const rating = document.getElementById('ratingValue').value;
            const fitur = Array.from(form.querySelectorAll('.feature-checkbox:checked')).map(cb => cb.value);
            const saran = form.querySelector('textarea').value;
            const rekomendasi = form.querySelector('input[name="rekomendasi"]:checked');

            // Validasi rating
            if (rating == 0) {
                alert('Silakan beri penilaian bintang terlebih dahulu! ⭐');
                return;
            }

            // Buat pesan sukses
            const ratingLabels = ['', '⭐ Sangat Tidak Puas', '⭐⭐ Tidak Puas', '⭐⭐⭐ Cukup Puas', '⭐⭐⭐⭐ Puas', '⭐⭐⭐⭐⭐ Sangat Puas'];
            const rekomText = rekomendasi ? rekomendasi.value : 'Tidak diisi';

            const fiturText = fitur.length > 0 ? fitur.join(', ') : 'Tidak memilih';

            const message = `
✅ Terima kasih, ${nama}!

📊 Ringkasan Penilaian:
• Rating: ${ratingLabels[rating] || rating + '⭐'}
• Fitur Favorit: ${fiturText}
• Rekomendasi: ${rekomText}
${saran ? '• Saran: ' + saran : ''}

🙏 Masukanmu sangat berharga untuk pengembangan program Agent PMB Metamedia!
            `;

            alert(message);

            // Reset form (opsional)
            // form.reset();
            // setRating(0);
            // document.querySelectorAll('.feature-checkbox').forEach(cb => cb.checked = false);
        }

        // ===== COUNTER ANGKA =====
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const suffix = element.getAttribute('data-suffix') || '';
            const duration = 2000;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentValue = Math.floor(easeOutQuart * target);

                element.textContent = currentValue + suffix;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target + suffix;
                }
            }

            requestAnimationFrame(updateCounter);
        }

        // ===== SCROLL ANIMATION OBSERVER =====
        const animateElements = document.querySelectorAll('.scroll-animate, .stagger-item, .nav-item');

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    if (!counter.classList.contains('counted')) {
                        counter.classList.add('counted');
                        animateCounter(counter);
                    }
                }
            });
        }, { threshold: 0.3 });

        document.querySelectorAll('.counter-number').forEach(el => {
            counterObserver.observe(el);
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const target = entry.target;
                if (entry.isIntersecting) {
                    target.classList.add('visible');
                } else {
                    target.classList.remove('visible');
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -30px 0px'
        });

        animateElements.forEach(el => observer.observe(el));

        // Init kalkulator
        calcBonus();

        window.addEventListener('load', () => {
            animateElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                if (isVisible) {
                    el.classList.add('visible');
                }
            });

            document.querySelectorAll('.counter-number').forEach(el => {
                const rect = el.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                if (isVisible && !el.classList.contains('counted')) {
                    el.classList.add('counted');
                    animateCounter(el);
                }
            });
        });
    </script>

    <x-lilin />

</body>

</html>
