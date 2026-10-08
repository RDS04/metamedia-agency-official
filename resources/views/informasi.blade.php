<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <title>Agent PMB Metamedia 2026</title>

    <!-- Vite Assets (Tailwind v4) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#018FD7',
                        'brand-dark': '#0073B1',
                        'brand-light': '#E6F4FC',
                        'brand-light-bg': '#F0F7FD',
                        structure: '#1E293B',
                        accent: '#018FD7',
                        'accent-light': '#E6F4FC',
                    }
                }
            }
        }
    </script>

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&family=Poppins:ital,wght@0,300..900;1,300..900&family=Inter:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <style>
        * {
            scroll-behavior: smooth;
        }

        /* ===== LIGHT MODE GLASS EFFECT ===== */
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
        }

        .glass-panel-light {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        /* ===== CUSTOM RANGE SLIDER ===== */
        input[type=range] {
            -webkit-appearance: none;
            height: 6px;
            border-radius: 3px;
            background: #E2E8F0;
            outline: none;
            transition: background 0.3s ease;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #018FD7;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(1, 143, 215, 0.3);
            transition: transform 0.1s ease, background-color 0.1s ease;
        }

        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }

        /* ===== SCROLL ANIMATION VARIANTS ===== */
        .scroll-animate {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .scroll-animate.visible {
            opacity: 1;
            transform: translate(0, 0) !important;
        }

        .from-left {
            transform: translateX(-40px);
        }

        .from-right {
            transform: translateX(40px);
        }

        .from-top {
            transform: translateY(-40px);
        }

        .from-bottom {
            transform: translateY(40px);
        }

        .stagger-item {
            opacity: 0;
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .stagger-item.visible {
            opacity: 1;
            transform: translate(0, 0) !important;
        }

        .stagger-item.delay-1 {
            transition-delay: 0.1s;
        }

        .stagger-item.delay-2 {
            transition-delay: 0.2s;
        }

        .stagger-item.delay-3 {
            transition-delay: 0.3s;
        }

        .stagger-item.delay-4 {
            transition-delay: 0.4s;
        }

        /* ===== RADIAL BACKGROUND GLOWS ===== */
        @keyframes float-glow {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -20px) scale(1.1);
            }
        }

        .radial-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.06;
            animation: float-glow 18s ease-in-out infinite;
        }

        .radial-glow:nth-of-type(2) {
            animation-duration: 25s;
            animation-delay: -5s;
        }

        /* Focus outline defaults */
        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        textarea:focus-visible {
            outline: 2px solid #018FD7;
            outline-offset: 4px;
        }

        /* ===== MARQUEE TESTIMONI ===== */
        @keyframes marquee-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-track {
            display: flex;
            gap: 1.5rem;
            width: max-content;
            animation: marquee-scroll 28s linear infinite;
        }

        .marquee-track:hover {
            animation-play-state: paused;
        }

        .marquee-card {
            width: 340px;
            flex-shrink: 0;
        }

        /* Gold star color for testimonial icons */
        .star-gold { color: #F59E0B; }
        .star-empty { color: #CBD5E1; }

        /* ===== MOBILE NAV ===== */
        #mobile-menu {
            display: none;
            flex-direction: column;
            gap: 0.25rem;
            padding: 1rem 1.25rem 1.5rem;
            background: rgba(255,255,255,0.98);
            border-top: 1px solid rgba(0,0,0,0.06);
            backdrop-filter: blur(12px);
        }
        #mobile-menu.open { display: flex; }
        #mobile-menu a {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            padding: 0.65rem 0.75rem;
            border-radius: 0.75rem;
            transition: background 0.15s, color 0.15s;
        }
        #mobile-menu a:hover { background: #EFF6FF; color: #018FD7; }
        #mobile-menu .mobile-cta {
            margin-top: 0.5rem;
            background: #018FD7;
            color: #fff !important;
            text-align: center;
            border-radius: 0.875rem;
            font-weight: 700;
        }
        #mobile-menu .mobile-cta:hover { background: #007ec2 !important; }

        /* Hamburger icon lines */
        .ham-line {
            display: block;
            width: 20px;
            height: 2px;
            background: #475569;
            border-radius: 2px;
            transition: transform 0.25s, opacity 0.25s;
        }
        #ham-btn.open .ham-line:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        #ham-btn.open .ham-line:nth-child(2) { opacity: 0; }
        #ham-btn.open .ham-line:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

        /* Marquee card width — narrower on mobile */
        @media (max-width: 640px) {
            .marquee-card { width: 280px; }
            .marquee-track { animation-duration: 20s; }
        }

        /* Hero: image below text on mobile */
        @media (max-width: 767px) {
            .hero-grid { display: flex; flex-direction: column-reverse; gap: 2rem; }
        }

        /* Reduced Motion Settings */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-delay: 0s !important;
                animation-duration: 0s !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0s !important;
                scroll-behavior: auto !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>
</head>

<body class="bg-[#E6F4FC] font-sans antialiased text-slate-700 selection:bg-brand/20 selection:text-brand-dark">

    <!-- ===== TOP NAVBAR ===== -->
    <div class="bg-[#0a3575] text-white text-xs font-semibold py-2.5 px-5 relative z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="ti ti-mail text-sm" aria-hidden="true"></i>
                <span>Email Kampus:</span>
                <a href="mailto:rektorat@metamedia.ac.id"
                    class="text-sky-300 hover:text-sky-200 transition-colors font-bold underline decoration-sky-300/30 hover:decoration-sky-200">
                    rektorat@metamedia.ac.id
                </a>
            </div>
            <div class="hidden sm:flex items-center gap-3">
                <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                <span>Program PMB Agen Resmi 2026</span>
            </div>
        </div>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="bg-white/80 backdrop-blur-lg border-b border-slate-200/50 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-5 flex items-center justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <i class="ti ti-school text-structure text-2xl filter drop-shadow-[0_2px_4px_rgba(48,90,166,0.2)]"
                    aria-hidden="true"></i>
                <span class="text-structure font-extrabold text-base tracking-wide flex items-center gap-1">
                    Agent PMB <span class="text-brand">Metamedia</span>
                </span>
            </div>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#keuntungan" class="text-slate-600 hover:text-brand text-sm font-semibold transition-colors">Keuntungan</a>
                <a href="#bonus" class="text-slate-600 hover:text-brand text-sm font-semibold transition-colors">Bonus</a>
                <a href="#cara-daftar" class="text-slate-600 hover:text-brand text-sm font-semibold transition-colors">Cara Daftar</a>
            </div>

            {{-- Desktop Buttons + Mobile Hamburger --}}
            <div class="flex items-center gap-2">
                @php
                    $isLoggedIn = Auth::check() || Auth::guard('agent_luar')->check() || Auth::guard('admin')->check();
                    $dashboardUrl = route('dashboard');
                    if (Auth::guard('admin')->check()) {
                        $dashboardUrl = route('dashboard.admin');
                    } elseif (Auth::guard('agent_luar')->check()) {
                        $dashboardUrl = route('agent-luar.dashboard');
                    }
                @endphp

                @if($isLoggedIn)
                    <a href="{{ $dashboardUrl }}"
                        class="bg-[#018FD7] hover:bg-[#0073B1] text-white text-sm font-bold px-5 py-2 rounded-xl transition-all duration-200 shadow-md shadow-sky-500/20 hover:scale-[1.02] active:scale-[0.98] inline-flex items-center gap-2">
                        <i class="ti ti-layout-dashboard text-base"></i>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('agent-luar.login') }}"
                        class="hidden sm:inline-flex text-slate-700 hover:text-[#018FD7] text-sm font-semibold px-4 py-2.5 rounded-xl border border-slate-200 hover:border-[#018FD7]/40 hover:bg-slate-50 transition-all duration-200">
                        Login
                    </a>
                    <a href="{{ route('agent-luar.register') }}"
                        class="hidden sm:inline-flex bg-[#018FD7] hover:bg-[#0073B1] text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-md shadow-sky-500/20 hover:scale-[1.02] active:scale-[0.98]">
                        Daftar
                    </a>
                @endif

                {{-- Hamburger button (mobile only) --}}
                <button id="ham-btn" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu"
                    class="md:hidden flex flex-col gap-1.5 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <span class="ham-line"></span>
                    <span class="ham-line"></span>
                    <span class="ham-line"></span>
                </button>
            </div>

        </div>

        {{-- Mobile Menu Drawer --}}
        <div id="mobile-menu" role="navigation" aria-label="Menu mobile">
            <a href="#keuntungan" class="mobile-nav-link">Keuntungan</a>
            <a href="#bonus" class="mobile-nav-link">Bonus</a>
            <a href="#cara-daftar" class="mobile-nav-link">Cara Daftar</a>
            @if($isLoggedIn)
                <a href="{{ $dashboardUrl }}" class="mobile-cta">Dashboard</a>
            @else
                <a href="{{ route('agent-luar.login') }}" class="mobile-nav-link">Login</a>
                <a href="{{ route('agent-luar.register') }}" class="mobile-cta">Daftar Sekarang</a>
            @endif
        </div>
    </nav>


    <!-- ===== HERO ===== -->
    <section
        class="relative bg-gradient-to-b from-[#E6F4FC] to-[#F0F7FD] pt-24 pb-32 px-5 overflow-hidden border-b border-slate-200/50">
        <!-- Background Ambient Lights using white and accent-light for soft brightness -->
        <div class="radial-glow bg-white w-[600px] h-[600px] -top-80 left-1/4 opacity-40"></div>
        <div class="radial-glow bg-accent-light w-[400px] h-[400px] -bottom-20 -right-20 opacity-20"></div>

        <div class="max-w-6xl mx-auto relative z-10">
            <div class="hero-grid grid md:grid-cols-2 gap-8 md:gap-12 items-center">

                <!-- Left: Image Gedung Metamedia -->
                <div class="scroll-animate from-left">
                    <div class="relative group">
                        <!-- Frame shadow & glow -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-[#018FD7]/10 to-transparent rounded-3xl blur-2xl opacity-60 group-hover:opacity-80 transition-opacity duration-500 -z-10">
                        </div>
                        <div
                            class="relative rounded-3xl overflow-hidden border border-slate-200/60 bg-white p-2 shadow-xl">
                            <img src="{{ asset('storage/gedungMetamedia.webp') }}" alt="Gedung Universitas Metamedia"
                                class="w-full h-auto rounded-2xl shadow-inner object-cover aspect-[4/3] group-hover:scale-[1.01] transition-transform duration-500">
                            <!-- Overlay badge -->
                            <div
                                class="absolute bottom-6 left-6 glass-panel rounded-2xl px-5 py-3 border border-white/80 shadow-lg">
                                <p class="text-structure text-sm font-extrabold tracking-wide flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 bg-brand rounded-full inline-block animate-pulse"></span>
                                    Metamedia
                                </p>
                                <p class="text-slate-500 text-xs mt-0.5 font-medium">Institusi Pendidikan Terpercaya</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Content Text -->
                <div class="scroll-animate from-right text-left">
                    <div
                        class="inline-flex items-center gap-2 bg-[#018FD7]/10 border border-[#018FD7]/20 text-[#018FD7] text-xs font-bold px-4 py-2 rounded-full mb-6 uppercase tracking-wider">
                        <i class="ti ti-sparkles text-sm animate-spin-slow" aria-hidden="true"></i>
                        Program Agent Resmi Metamedia 2026
                    </div>

                    <h1
                        class="text-3xl md:text-5xl font-black text-slate-900 leading-tight mb-5 md:mb-6 tracking-tight">
                        Bantu Calon Mahasiswa,<br>
                        <span class="text-[#018FD7]">Dapatkan Bonus Tunai</span>
                    </h1>

                    <p class="text-slate-600 text-base md:text-lg mb-8 leading-relaxed font-normal">
                        Jadilah partner resmi PMB Metamedia. Rekomendasikan calon mahasiswa dan dapatkan komisi instan
                        langsung ke rekening pribadi Anda tanpa target dan kerumitan.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="#daftar"
                            class="bg-[#018FD7] hover:bg-[#007ec2] text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 text-sm text-center shadow-lg shadow-[#018FD7]/15 hover:shadow-[#018FD7]/30 hover:scale-[1.02] active:scale-[0.98]">
                            Daftar Jadi Agent Sekarang
                        </a>
                        <a href="#bonus"
                            class="border border-slate-200 hover:border-[#018FD7]/40 text-slate-600 hover:text-[#018FD7] px-8 py-4 rounded-2xl transition-all duration-300 text-sm text-center hover:bg-white font-semibold">
                            Lihat Struktur Bonus
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-200/60">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-circle-check-filled text-[#018FD7] text-lg" aria-hidden="true"></i>
                            <span class="text-slate-600 text-xs font-bold">Gratis mendaftar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="ti ti-circle-check-filled text-[#018FD7] text-lg" aria-hidden="true"></i>
                            <span class="text-slate-600 text-xs font-bold">Tanpa target minimum</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="ti ti-circle-check-filled text-[#018FD7] text-lg" aria-hidden="true"></i>
                            <span class="text-slate-600 text-xs font-bold">Komisi langsung cair</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== STATS BAR ===== -->
    <section class="relative z-20 -mt-12 px-5">
        <div
            class="max-w-6xl mx-auto bg-white/90 backdrop-blur-md border border-white/60 rounded-3xl py-8 px-6 shadow-xl grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="scroll-animate from-top">
                <div class="text-brand text-3xl md:text-4xl font-black tracking-tight">
                    <span class="counter-number" data-target="12000" data-suffix="+">0</span>
                </div>
                <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-1.5">Mahasiswa Aktif</div>
            </div>
            <div class="scroll-animate from-bottom">
                <div class="text-brand text-3xl md:text-4xl font-black tracking-tight">
                    <span class="counter-number" data-target="25">0</span>
                </div>
                <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-1.5">Program Studi</div>
            </div>
            <div class="scroll-animate from-top">
                <div class="text-brand text-3xl md:text-4xl font-black tracking-tight">
                    <span class="counter-number" data-target="500" data-suffix="+">0</span>
                </div>
                <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-1.5">Dosen Ahli</div>
            </div>
            <div class="scroll-animate from-bottom">
                <div class="text-brand text-3xl md:text-4xl font-black tracking-tight">
                    <span class="counter-number" data-target="20000" data-suffix="+">0</span>
                </div>
                <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-1.5">Alumni Sukses</div>
            </div>
        </div>
    </section>


    <!-- ===== KEUNTUNGAN ===== -->
    <section id="keuntungan" class="bg-transparent py-24 px-5 relative overflow-hidden">
        <div class="radial-glow bg-accent-light w-[400px] h-[400px] top-1/2 left-0 -translate-y-1/2"></div>
        <div class="max-w-6xl mx-auto relative z-10">

            <div class="text-center mb-16 scroll-animate from-left">
                <p class="text-brand text-xs font-bold uppercase tracking-widest mb-3">Keuntungan Partner</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Kenapa Harus
                    Bergabung?</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed font-medium">
                    Tidak memerlukan pengalaman atau modal khusus. Cukup manfaatkan jaringan relasi Anda dan mulai
                    hasilkan pendapatan.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white border border-slate-200/60 hover:border-brand/40 hover:shadow-xl hover:scale-[1.03] transition-all duration-300 rounded-3xl p-6 shadow-sm flex flex-col justify-between stagger-item from-bottom delay-1 group">
                    <div>
                        <div
                            class="w-12 h-12 bg-brand-light group-hover:bg-brand/20 rounded-2xl flex items-center justify-center mb-6 transition-colors duration-300">
                            <i class="ti ti-cash text-brand text-2xl" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-3">Bonus Langsung Cair</h3>
                        <p class="text-slate-500 text-xs leading-relaxed font-medium">Komisi ditransfer langsung ke
                            rekening terdaftar setelah mahasiswa melakukan registrasi dan divalidasi.</p>
                    </div>
                </div>

                <div
                    class="bg-white border border-slate-200/60 hover:border-structure/40 hover:shadow-xl hover:scale-[1.03] transition-all duration-300 rounded-3xl p-6 shadow-sm flex flex-col justify-between stagger-item from-bottom delay-2 group">
                    <div>
                        <div
                            class="w-12 h-12 bg-structure-light group-hover:bg-structure/20 rounded-2xl flex items-center justify-center mb-6 transition-colors duration-300">
                            <i class="ti ti-trending-up text-structure text-2xl" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-3">Sistem Tiering Premium</h3>
                        <p class="text-slate-500 text-xs leading-relaxed font-medium">Semakin banyak mahasiswa yang
                            direkomendasikan, semakin tinggi level komisi per orang yang didapat.</p>
                    </div>
                </div>

                <div
                    class="bg-white border border-slate-200/60 hover:border-brand/40 hover:shadow-xl hover:scale-[1.03] transition-all duration-300 rounded-3xl p-6 shadow-sm flex flex-col justify-between stagger-item from-bottom delay-3 group">
                    <div>
                        <div
                            class="w-12 h-12 bg-brand-light group-hover:bg-brand/20 rounded-2xl flex items-center justify-center mb-6 transition-colors duration-300">
                            <i class="ti ti-device-mobile text-brand text-2xl" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-3">Dashboard Real-time</h3>
                        <p class="text-slate-500 text-xs leading-relaxed font-medium">Pantau aktivitas pendaftaran,
                            referral, status pembayaran, dan total komisi melalui dashboard dinamis.</p>
                    </div>
                </div>

                <div
                    class="bg-white border border-slate-200/60 hover:border-structure/40 hover:shadow-xl hover:scale-[1.03] transition-all duration-300 rounded-3xl p-6 shadow-sm flex flex-col justify-between stagger-item from-bottom delay-4 group">
                    <div>
                        <div
                            class="w-12 h-12 bg-structure-light group-hover:bg-structure/20 rounded-2xl flex items-center justify-center mb-6 transition-colors duration-300">
                            <i class="ti ti-shield-check text-structure text-2xl" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-3">Program Resmi & Aman</h3>
                        <p class="text-slate-500 text-xs leading-relaxed font-medium">Program dikoordinasikan secara
                            resmi oleh institusi perguruan tinggi terakreditasi nasional.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== BONUS TIERS + KALKULATOR ===== -->
    <section id="bonus" class="bg-transparent py-24 px-5 relative overflow-hidden">
        <div class="radial-glow bg-accent-light w-[400px] h-[400px] bottom-0 right-1/4"></div>
        <div class="max-w-6xl mx-auto relative z-10">

            <div class="text-center mb-16 scroll-animate from-right">
                <p class="text-brand text-xs font-bold uppercase tracking-widest mb-3">Struktur Komisi</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Simulasi Penghasilan
                    Anda</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed font-medium">
                    Lihat perkembangan pendapatan Anda seiring dengan bertambahnya jumlah pendaftar yang
                    direkomendasikan.
                </p>
            </div>

            <div class="grid lg:grid-cols-12 gap-8 items-stretch">

                <!-- Left: Tiering List -->
                <div class="lg:col-span-7 scroll-animate from-left flex flex-col justify-between">
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 h-full shadow-sm">
                        <div class="px-6 py-5 border-b border-slate-200/80 bg-slate-50">
                            <h3 class="text-base font-bold text-slate-950 flex items-center gap-2">
                                <i class="ti ti-award text-structure text-lg" aria-hidden="true"></i>
                                Level Bonus Agent
                            </h3>
                        </div>

                        <div class="divide-y divide-slate-100">
                            <div id="tier-starter"
                                class="flex items-center justify-between px-6 py-5 transition-all duration-300 border-l-4 border-l-transparent">
                                <div class="flex items-center gap-4">
                                    <div class="w-4 h-4 rounded-full bg-slate-200 border-4 border-slate-400"></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Starter</p>
                                        <p class="text-xs text-slate-400 mt-0.5 font-medium">1 – 5 mahasiswa</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-900">Rp 250.000</p>
                                    <p class="text-xs text-slate-400 mt-0.5 font-medium">per mahasiswa</p>
                                </div>
                            </div>

                            <div id="tier-silver"
                                class="flex items-center justify-between px-6 py-5 transition-all duration-300 border-l-4 border-l-transparent">
                                <div class="flex items-center gap-4">
                                    <div class="w-4 h-4 rounded-full bg-brand-light border-4 border-brand"></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Silver</p>
                                        <p class="text-xs text-slate-400 mt-0.5 font-medium">6 – 15 mahasiswa</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-900">Rp 400.000</p>
                                    <p class="text-xs text-slate-400 mt-0.5 font-medium">per mahasiswa</p>
                                </div>
                            </div>

                            <div id="tier-gold"
                                class="flex items-center justify-between px-6 py-5 transition-all duration-300 border-l-4 border-l-transparent">
                                <div class="flex items-center gap-4">
                                    <div class="w-4 h-4 rounded-full bg-brand-light border-4 border-brand"></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Gold</p>
                                        <p class="text-xs text-slate-400 mt-0.5 font-medium">16 – 30 mahasiswa</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-900">Rp 600.000</p>
                                    <p class="text-xs text-slate-400 mt-0.5 font-medium">per mahasiswa</p>
                                </div>
                            </div>

                            <div id="tier-platinum"
                                class="flex items-center justify-between px-6 py-5 transition-all duration-300 border-l-4 border-l-transparent">
                                <div class="flex items-center gap-4">
                                    <div class="w-4 h-4 rounded-full bg-structure-light border-4 border-structure">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Platinum</p>
                                        <p class="text-xs text-slate-400 mt-0.5 font-medium">31+ mahasiswa</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-structure">Rp 850.000</p>
                                    <p class="text-xs text-slate-400 mt-0.5 font-medium">per mahasiswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Calculator Card -->
                <div class="lg:col-span-5 scroll-animate from-right">
                    <div
                        class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 md:p-8 relative h-full flex flex-col justify-between shadow-sm overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-brand/5 to-transparent pointer-events-none">
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center gap-2 mb-6">
                                <i class="ti ti-calculator text-structure text-xl" aria-hidden="true"></i>
                                <h3 class="text-slate-900 text-base font-bold">Kalkulator Simulasi</h3>
                            </div>

                            <div class="mb-8">
                                <div class="flex justify-between items-baseline mb-3">
                                    <label for="mhsSlider"
                                        class="text-slate-500 text-xs font-bold uppercase tracking-wider">Rekomendasi
                                        Sukses</label>
                                    <span class="text-brand text-2xl font-black" id="mhsVal">10</span>
                                </div>
                                <input type="range" id="mhsSlider" min="1" max="50" value="10" step="1"
                                    class="w-full cursor-pointer focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none rounded-lg"
                                    oninput="calcBonus()">
                                <div class="flex justify-between mt-2 px-1">
                                    <span class="text-slate-400 text-xs font-semibold">1 Maba</span>
                                    <span class="text-slate-400 text-xs font-semibold">50 Maba</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-white border border-slate-200/60 rounded-2xl p-4 shadow-sm">
                                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-wider mb-1">Tier
                                        Saat Ini</p>
                                    <p class="text-slate-900 text-lg font-black" id="tierLabel">Silver</p>
                                </div>
                                <div class="bg-white border border-slate-200/60 rounded-2xl p-4 shadow-sm">
                                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-wider mb-1">Komisi
                                        / Orang</p>
                                    <p class="text-slate-900 text-lg font-black" id="perMhs">Rp 400rb</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="relative z-10 bg-brand/5 border border-brand/20 rounded-2xl p-5 text-center shadow-inner mt-auto">
                            <p class="text-slate-500 text-xs font-bold mb-1.5">Estimasi Total Pendapatan</p>
                            <p class="text-brand text-3xl font-black tracking-tight" id="totalBonus">Rp 4.000.000</p>
                            <p class="text-[10px] text-slate-400 mt-2 font-medium">* Angka di atas bersifat simulasi
                                komisi resmi.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== CARA DAFTAR ===== -->
    <section id="cara-daftar" class="bg-transparent py-24 px-5 relative overflow-hidden">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-16 scroll-animate from-top">
                <p class="text-brand text-xs font-bold uppercase tracking-widest mb-3">Langkah Pendaftaran</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">4 Langkah Mudah
                    Menjadi Agent</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed font-medium">
                    Registrasi instan tanpa persyaratan dokumen berbelit-belit. Mulai hasilkan uang hari ini.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white border border-slate-200/60 rounded-3xl p-6 text-center hover:border-brand/35 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-item from-bottom delay-1 relative">
                    <div
                        class="w-10 h-10 bg-slate-50 border border-slate-200 text-slate-700 rounded-full flex items-center justify-center mx-auto mb-6 text-sm font-black shadow-sm">
                        1</div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Daftar Akun</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-medium">Lengkapi formulir registrasi online
                        gratis. Cukup butuh waktu sekitar 2&nbsp;menit saja.</p>
                </div>

                <div
                    class="bg-white border border-slate-200/60 rounded-3xl p-6 text-center hover:border-brand/35 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-item from-bottom delay-2 relative">
                    <div
                        class="w-10 h-10 bg-slate-50 border border-slate-200 text-slate-700 rounded-full flex items-center justify-center mx-auto mb-6 text-sm font-black shadow-sm">
                        2</div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Dapatkan Kode</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-medium">Dapatkan kode dan tautan referal unik
                        Anda secara langsung setelah akun terverifikasi.</p>
                </div>

                <div
                    class="bg-white border border-slate-200/60 rounded-3xl p-6 text-center hover:border-brand/35 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-item from-bottom delay-3 relative">
                    <div
                        class="w-10 h-10 bg-slate-50 border border-slate-200 text-slate-700 rounded-full flex items-center justify-center mx-auto mb-6 text-sm font-black shadow-sm">
                        3</div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Bagikan Info</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-medium">Bagikan info perkuliahan dan kode
                        referal Anda kepada calon mahasiswa potensial.</p>
                </div>

                <div
                    class="bg-white border border-slate-200/60 rounded-3xl p-6 text-center hover:border-structure/35 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-item from-bottom delay-4 relative">
                    <div
                        class="w-10 h-10 bg-structure-light border border-structure/20 text-structure rounded-full flex items-center justify-center mx-auto mb-6 text-sm font-black shadow-sm">
                        4</div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Terima Komisi 🎉</h3>
                    <p class="text-slate-500 text-xs leading-relaxed font-medium">Pendapatan ditransfer langsung setelah
                        calon mahasiswa menyelesaikan pembayaran awal.</p>
                </div>

            </div>
        </div>
    </section>


    <!-- ===== TESTIMONI ===== -->
    <section class="bg-transparent py-24 relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center mb-16 scroll-animate from-bottom">
                <p class="text-brand text-xs font-bold uppercase tracking-widest mb-3">Testimonial</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Kisah Sukses Agent
                    Kami</h2>
                <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed font-medium">
                    Pendapat nyata dari para agent yang telah bergabung bersama kami.
                </p>
            </div>
        </div>

        @if($testimoni->isNotEmpty())
            {{-- Marquee: overflow full-width, no px padding --}}
            <div class="overflow-hidden w-full" aria-label="Testimoni Agent">
                <div class="marquee-track">

                    {{-- Render dua kali untuk loop seamless --}}
                    @foreach([1] as $_loop)
                        @foreach($testimoni as $index => $t)
                            @php
                                $bgColors   = ['#EFF6FF','#F0F9FF','#F0FDF4'];
                                $dotColors  = ['#018FD7','#0a3575','#16a34a'];
                                $bgColor    = $bgColors[$index % 3];
                                $dotColor   = $dotColors[$index % 3];
                            @endphp
                            <div class="marquee-card bg-white border border-slate-200/70 rounded-3xl p-6 shadow-sm flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-shadow duration-300">
                                <div>
                                    {{-- Rating bintang: hanya tampilkan bintang terisi sesuai rating --}}
                                    <div class="flex items-center gap-0.5 mb-4" aria-label="Rating {{ $t->rating }} dari 5">
                                        @for($s = 1; $s <= $t->rating; $s++)
                                            <i class="ti ti-star-filled text-lg star-gold" aria-hidden="true"></i>
                                        @endfor
                                        <span class="ml-2 text-xs font-bold" style="color:#F59E0B">{{ $t->rating }}/5</span>
                                    </div>

                                    {{-- Isi Testimoni --}}
                                    <p class="text-slate-600 text-sm leading-relaxed italic font-medium line-clamp-4">
                                        &ldquo;{{ $t->saran ?: 'Terima kasih atas program yang luar biasa ini!' }}&rdquo;
                                    </p>
                                </div>

                                {{-- Footer --}}
                                <div class="flex items-center gap-3 pt-4 mt-5 border-t border-slate-100">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold shadow-sm flex-shrink-0"
                                        style="background:{{ $bgColor }}; color:{{ $dotColor }};">
                                        {{ $t->inisial }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-slate-900 text-sm font-bold truncate">{{ $t->nama_lengkap }}</p>
                                        @if($t->rekomendasi)
                                            <p class="text-slate-400 text-xs mt-0.5 font-medium truncate">{{ $t->rekomendasi }}</p>
                                        @else
                                            <p class="text-slate-400 text-xs mt-0.5 font-medium">Agent Terverifikasi ✓</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                </div>
            </div>
        @else
            <div class="text-center py-12 px-5">
                <div class="w-16 h-16 bg-brand-light rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-messages text-brand text-2xl"></i>
                </div>
                <p class="text-slate-500 text-sm font-medium">Belum ada testimonial. Jadilah yang pertama berbagi pengalaman!</p>
                <a href="#daftar" class="inline-block mt-4 text-brand text-sm font-bold hover:underline">Tulis Testimoni &rarr;</a>
            </div>
        @endif
    </section>


    <!-- ===== CTA BOTTOM - FORM KEPUASAN AGENT ===== -->
    <section id="daftar" class="bg-transparent py-24 px-5 relative overflow-hidden border-t border-slate-200/40">
        <div class="radial-glow bg-accent-light w-[400px] h-[400px] -bottom-20 left-1/2 -translate-x-1/2"></div>
        <div class="max-w-3xl mx-auto relative z-10 scroll-animate from-bottom">

            <!-- Header -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center gap-2 bg-brand-light border border-brand/20 text-brand text-xs font-semibold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">
                    <i class="ti ti-heart-filled text-sm" aria-hidden="true"></i>
                    Kepuasan Agent
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Bagaimana Kepuasan Anda?</h2>
                <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                    Pendapat Anda sangat berharga bagi kami. Bagikan pengalaman Anda untuk membantu kami meningkatkan
                    kualitas program Agent PMB Metamedia.
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-10 shadow-lg relative">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-50/50 to-transparent pointer-events-none">
                </div>

                {{-- Flash success --}}
                @if(session('success'))
                    <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 text-sm font-medium">
                        <i class="ti ti-circle-check-filled text-green-500 text-xl mt-0.5 flex-shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                {{-- Validation errors --}}
                @if($errors->any())
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4 text-sm font-medium">
                        <i class="ti ti-alert-circle-filled text-red-500 text-xl mt-0.5 flex-shrink-0"></i>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="surveyForm" method="POST" action="{{ route('pesan.store') }}"
                    class="space-y-6 relative z-10">
                    @csrf

                    <!-- 1. Nama Lengkap -->
                    <div>
                        <label for="fullName" class="text-sm text-slate-700 font-bold mb-2 flex items-center gap-2">
                            <i class="ti ti-user text-brand text-base" aria-hidden="true"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" id="fullName" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda…" required
                            value="{{ old('nama_lengkap') }}"
                            class="w-full bg-slate-50 border border-slate-200 hover:border-slate-300 focus:border-brand text-slate-900 text-sm placeholder-slate-400 px-4 py-3.5 rounded-2xl transition-colors duration-200 outline-none focus:ring-2 focus:ring-brand/20">
                    </div>

                    <!-- 2. Email -->
                    <div>
                        <label for="emailAddr" class="text-sm text-slate-700 font-bold mb-2 flex items-center gap-2">
                            <i class="ti ti-mail text-brand text-base" aria-hidden="true"></i>
                            Email
                        </label>
                        <input type="email" id="emailAddr" name="email" placeholder="nama@email.com…" required spellcheck="false"
                            value="{{ old('email') }}"
                            class="w-full bg-slate-50 border border-slate-200 hover:border-slate-300 focus:border-brand text-slate-900 text-sm placeholder-slate-400 px-4 py-3.5 rounded-2xl transition-colors duration-200 outline-none focus:ring-2 focus:ring-brand/20">
                    </div>

                    <!-- 3. Rating Bintang (Accessible) -->
                    <div>
                        <label class="text-sm text-slate-700 font-bold mb-3 flex items-center gap-2">
                            <i class="ti ti-star text-brand text-base" aria-hidden="true"></i>
                            Tingkat Kepuasan Program Agent
                        </label>
                        <div class="rating-stars flex gap-2 justify-center my-3" id="ratingStars" role="radiogroup"
                            aria-label="Rating Kepuasan">
                            <button type="button"
                                class="star group p-1 hover:scale-110 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand rounded-xl"
                                data-value="1" onclick="setRating(1)" role="radio" aria-checked="false"
                                aria-label="Sangat Tidak Puas">
                                <svg class="w-8 h-8 fill-current transition-colors" style="color:#CBD5E1" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                            <button type="button"
                                class="star group p-1 hover:scale-110 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand rounded-xl"
                                data-value="2" onclick="setRating(2)" role="radio" aria-checked="false"
                                aria-label="Tidak Puas">
                                <svg class="w-8 h-8 fill-current transition-colors" style="color:#CBD5E1" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                            <button type="button"
                                class="star group p-1 hover:scale-110 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand rounded-xl"
                                data-value="3" onclick="setRating(3)" role="radio" aria-checked="false"
                                aria-label="Cukup Puas">
                                <svg class="w-8 h-8 fill-current transition-colors" style="color:#CBD5E1" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                            <button type="button"
                                class="star group p-1 hover:scale-110 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand rounded-xl"
                                data-value="4" onclick="setRating(4)" role="radio" aria-checked="false"
                                aria-label="Puas">
                                <svg class="w-8 h-8 fill-current transition-colors" style="color:#CBD5E1" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                            <button type="button"
                                class="star group p-1 hover:scale-110 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-brand rounded-xl"
                                data-value="5" onclick="setRating(5)" role="radio" aria-checked="false"
                                aria-label="Sangat Puas">
                                <svg class="w-8 h-8 fill-current transition-colors" style="color:#CBD5E1" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="{{ old('rating', 0) }}">
                        <p class="text-center text-slate-400 text-xs mt-2" id="ratingLabel">Klik salah satu bintang di
                            atas untuk menilai</p>
                    </div>

                    <!-- 4. Fitur Favorit (Checkbox) -->
                    <div>
                        <label class="text-sm text-slate-700 font-bold mb-3 flex items-center gap-2">
                            <i class="ti ti-thumb-up text-brand text-base" aria-hidden="true"></i>
                            Fitur Favorit Anda (Bisa pilih lebih dari satu)
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label
                                class="flex items-center gap-3 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors p-3 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300">
                                <input type="checkbox"
                                    class="feature-checkbox accent-brand w-5 h-5 rounded-lg border-slate-300 bg-white focus:ring-brand"
                                    name="fitur_favorit[]" value="Bonus Langsung Cair">
                                <span>Bonus Langsung Cair</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors p-3 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300">
                                <input type="checkbox"
                                    class="feature-checkbox accent-brand w-5 h-5 rounded-lg border-slate-300 bg-white focus:ring-brand"
                                    name="fitur_favorit[]" value="Dashboard Real-time">
                                <span>Dashboard Real-time</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors p-3 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300">
                                <input type="checkbox"
                                    class="feature-checkbox accent-brand w-5 h-5 rounded-lg border-slate-300 bg-white focus:ring-brand"
                                    name="fitur_favorit[]" value="Struktur Bonus Tier">
                                <span>Struktur Bonus Tier</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors p-3 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300">
                                <input type="checkbox"
                                    class="feature-checkbox accent-brand w-5 h-5 rounded-lg border-slate-300 bg-white focus:ring-brand"
                                    name="fitur_favorit[]" value="Kalkulator Simulasi">
                                <span>Kalkulator Simulasi</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors p-3 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300">
                                <input type="checkbox"
                                    class="feature-checkbox accent-brand w-5 h-5 rounded-lg border-slate-300 bg-white focus:ring-brand"
                                    name="fitur_favorit[]" value="Testimoni Agent">
                                <span>Testimoni Agent Lain</span>
                            </label>
                            <label
                                class="flex items-center gap-3 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors p-3 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300">
                                <input type="checkbox"
                                    class="feature-checkbox accent-brand w-5 h-5 rounded-lg border-slate-300 bg-white focus:ring-brand"
                                    name="fitur_favorit[]" value="Lainnya">
                                <span>Lainnya</span>
                            </label>
                        </div>
                    </div>

                    <!-- 5. Saran & Masukan -->
                    <div>
                        <label for="suggestion" class="text-sm text-slate-700 font-bold mb-2 flex items-center gap-2">
                            <i class="ti ti-message-circle text-brand text-base" aria-hidden="true"></i>
                            Saran &amp; Masukan
                        </label>
                        <textarea id="suggestion" name="saran" placeholder="Tuliskan masukan berharga Anda di sini…"
                            class="w-full bg-slate-50 border border-slate-200 hover:border-slate-300 focus:border-brand text-slate-900 text-sm placeholder-slate-400 px-4 py-3.5 rounded-2xl transition-colors duration-200 outline-none focus:ring-2 focus:ring-brand/20 h-28 resize-y">{{ old('saran') }}</textarea>
                    </div>

                    <!-- 6. Rekomendasi -->
                    <div>
                        <label class="text-sm text-slate-700 font-bold mb-3 flex items-center gap-2">
                            <i class="ti ti-share text-brand text-base" aria-hidden="true"></i>
                            Apakah Anda akan merekomendasikan program ini ke rekan Anda?
                        </label>
                        <div class="flex flex-wrap gap-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                            <label
                                class="flex items-center gap-2 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors">
                                <input type="radio" name="rekomendasi" value="Ya, pasti!" class="accent-brand w-4 h-4">
                                <span>Ya, pasti!</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors">
                                <input type="radio" name="rekomendasi" value="Mungkin" class="accent-brand w-4 h-4">
                                <span>Mungkin</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors">
                                <input type="radio" name="rekomendasi" value="Belum tahu" class="accent-brand w-4 h-4">
                                <span>Belum tahu</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-slate-500 text-sm cursor-pointer hover:text-slate-900 transition-colors">
                                <input type="radio" name="rekomendasi" value="Tidak" class="accent-brand w-4 h-4">
                                <span>Tidak</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                        class="w-full bg-[#018FD7] hover:bg-brand-dark text-white font-bold py-4 rounded-2xl transition-all duration-300 text-sm hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2 shadow-lg shadow-brand/10 hover:shadow-brand/25">
                        <span id="submitSpinner"
                            class="hidden animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <i class="ti ti-send text-base" id="submitIcon" aria-hidden="true"></i>
                        <span id="btnText">Kirim Penilaian</span>
                    </button>

                    <p class="text-center text-slate-400 text-xs font-medium">
                        <i class="ti ti-lock text-xs mr-1" aria-hidden="true"></i>
                        Data masukan Anda aman dan terenkripsi.
                    </p>

                </form>

            </div>

        </div>
    </section>


    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-900 text-slate-400 py-16 px-5 border-t border-slate-800">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <i class="ti ti-school text-brand text-2xl filter drop-shadow-[0_2px_4px_rgba(1,142,214,0.2)]"
                    aria-hidden="true"></i>
                <span class="text-white text-base font-bold">Agent PMB <span class="text-brand">Metamedia</span></span>
            </div>
            <div class="flex gap-8 font-semibold text-sm">
                <a href="#" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Kontak</a>
            </div>
            <p class="text-slate-500 text-xs font-medium">© 2026 Universitas Metamedia. All Rights Reserved.</p>
        </div>
    </footer>


    <!-- ===== SCRIPTS ===== -->
    <script>
        // ===== HAMBURGER MENU =====
        (function () {
            const btn  = document.getElementById('ham-btn');
            const menu = document.getElementById('mobile-menu');
            if (!btn || !menu) return;

            btn.addEventListener('click', function () {
                const isOpen = menu.classList.toggle('open');
                btn.classList.toggle('open', isOpen);
                btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                btn.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
            });

            // Close menu when a nav link is clicked
            menu.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    menu.classList.remove('open');
                    btn.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                });
            });

            // Close on outside click
            document.addEventListener('click', function (e) {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('open');
                    btn.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        })();

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
                    el.classList.add('border-l-brand', 'bg-brand-light-bg');
                } else {
                    el.classList.remove('border-l-brand', 'bg-brand-light-bg');
                }
            });
        }

        // ===== RATING BINTANG =====
        let selectedRating = 0;

        function setRating(value) {
            selectedRating = value;
            document.getElementById('ratingValue').value = value;

            const stars = document.querySelectorAll('#ratingStars .star');
            stars.forEach((star, index) => {
                const svg = star.querySelector('svg');
                if (index < value) {
                    star.setAttribute('aria-checked', 'true');
                    svg.style.color = '#F59E0B'; // amber-400 = gold
                } else {
                    star.setAttribute('aria-checked', 'false');
                    svg.style.color = '#CBD5E1'; // slate-300
                }
            });

            const labels = ['', 'Sangat Tidak Puas', 'Tidak Puas', 'Cukup Puas', 'Puas', 'Sangat Puas'];
            document.getElementById('ratingLabel').textContent = labels[value] || 'Klik salah satu bintang di atas untuk menilai';
        }

        // Hover effects for rating stars
        document.querySelectorAll('#ratingStars .star').forEach(star => {
            star.addEventListener('mouseenter', function () {
                const value = parseInt(this.dataset.value);
                const stars = document.querySelectorAll('#ratingStars .star');
                stars.forEach((s, index) => {
                    const svg = s.querySelector('svg');
                    svg.style.color = index < value ? '#F59E0B' : '#CBD5E1';
                });
            });
            star.addEventListener('mouseleave', function () {
                const stars = document.querySelectorAll('#ratingStars .star');
                stars.forEach((s, index) => {
                    const svg = s.querySelector('svg');
                    svg.style.color = index < selectedRating ? '#F59E0B' : '#CBD5E1';
                });
            });
        });

        // ===== HANDLE SURVEY SUBMIT =====
        function handleSurvey(e) {
            e.preventDefault();

            const rating = document.getElementById('ratingValue').value;
            if (rating == 0) {
                alert('Silakan beri penilaian bintang terlebih dahulu! ⭐');
                return;
            }

            // Show loading spinner
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');
            const icon = document.getElementById('submitIcon');
            const btnText = document.getElementById('btnText');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            icon.classList.add('hidden');
            btnText.textContent = 'Mengirimkan…';

            setTimeout(() => {
                // Ambil data dari form
                const form = e.target;
                const nama = document.getElementById('fullName').value;
                const email = document.getElementById('emailAddr').value;
                const fitur = Array.from(form.querySelectorAll('.feature-checkbox:checked')).map(cb => cb.value);
                const saran = document.getElementById('suggestion').value;
                const rekomendasi = form.querySelector('input[name="rekomendasi"]:checked');

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

🙏 Masukan Anda sangat berharga untuk pengembangan program Agent PMB Metamedia!
                `;

                alert(message);

                // Reset spinner
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
                icon.classList.remove('hidden');
                btnText.textContent = 'Kirim Penilaian';

                // Reset form
                form.reset();
                setRating(0);
            }, 1000);
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
        const animateElements = document.querySelectorAll('.scroll-animate, .stagger-item');

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