@extends('auth.layout.app')

@section('title', 'Tambah Agent')

@section('content')

<style>
    .input-focus {
        transition: all .2s ease;
    }

    .input-focus:focus {
        border-color: #018FD7;
        box-shadow: 0 0 0 4px rgba(1, 143, 215, .12);
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #018FD7, #0073b1);
        transition: all .2s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0073b1, #005f94);
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(1, 143, 215, .24);
    }

    .badge-referral {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-color: #7dd3fc;
    }
</style>

<div class="space-y-6 px-2 py-2 lg:px-0">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1 text-sm font-semibold text-sky-700">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a5 5 0 00-5 5v1H4a1 1 0 00-1 1v7a1 1 0 001 1h12a1 1 0 001-1v-7a1 1 0 00-1-1h-1V7a5 5 0 00-5-5zm-3 6V7a3 3 0 116 0v1H7zm8 8H5v-5h10v5z" />
                </svg>
                Form Pendaftaran Agent
            </div>
            <h1 class="mt-3 text-3xl font-bold text-slate-800">
                Tambah Agent
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Tambahkan data agent baru dengan formulir yang lebih jelas dan modern.
            </p>
        </div>

        <a href="{{ route('agen.Create') }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
            ← Kembali
        </a>
    </div>

    @if($targetBonusUkt)
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-800">
                    {{ $isMitra ? 'Progress Bonus Mitra' : 'Progress Potongan UKT' }}
                </p>
                <p class="mt-1 text-sm text-slate-500">
                    @if($isMitra)
                    Anda memiliki {{ $targetProgressCount }} dari target {{ $targetBonusUkt }} mahasiswa registrasi ulang.
                    @else
                    Anda sudah mendaftarkan {{ $targetProgressCount }} dari target {{ $targetBonusUkt }} calon mahasiswa.
                    @endif
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="min-w-48">
                    <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-[#018FD7]"
                            style="width: {{ min(100, round(($targetProgressCount / max(1, $targetBonusUkt)) * 100)) }}%">
                        </div>
                    </div>
                </div>

                @if($potonganUktTercapai)
                <span class="inline-flex items-center justify-center rounded-lg bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                    @if($isMitra)
                    Bonus Rp {{ number_format($komisiAktif->bonus_pertama, 0, ',', '.') }} tercapai
                    @else
                    Potongan UKT {{ $komisiAktif->potongan_ukt_persen }}% aktif
                    @endif
                </span>
                @elseif($akanTercapaiSetelahSimpan)
                <span class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                    Simpan 1 camaba lagi untuk aktif
                </span>
                @else
                <span class="inline-flex items-center justify-center rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                    Kurang {{ $sisaTargetUkt }} {{ $isMitra ? 'registrasi ulang' : 'camaba' }} lagi
                </span>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_25px_80px_-30px_rgba(1,143,215,0.45)]">
        <div class="border-b border-slate-100 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-5 lg:px-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">
                        Form Tambah Agent
                    </h2>
                    <p class="mt-1 text-sm text-sky-100">
                        Isi data dengan lengkap agar akun dapat aktif segera.
                    </p>
                </div>
                <div class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-sm font-medium text-white backdrop-blur-sm">
                    <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a5 5 0 00-5 5v1H4a1 1 0 00-1 1v7a1 1 0 001 1h12a1 1 0 001-1v-7a1 1 0 00-1-1h-1V7a5 5 0 00-5-5zm-3 6V7a3 3 0 116 0v1H7zm8 8H5v-5h10v5z" />
                    </svg>
                    Aman & Cepat
                </div>
            </div>
        </div>

        <div class="p-6 lg:p-8">
            @if(session('success'))
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('agent-luar.register.store') }}" method="POST" class="space-y-6" id="registerForm">
                @csrf

                <div class="rounded-2xl border border-sky-200 bg-sky-50/70 p-4">
                    <label class="mb-1.5 block text-sm font-semibold text-sky-900">
                        🔑 Kode Referral Agent Internal
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kode_referral_dipakai" value="{{ old('kode_referral_dipakai') }}"
                        placeholder="Contoh: REF-ABCD1234" maxlength="20"
                        class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-sm font-mono tracking-wider text-slate-800 uppercase input-focus"
                        oninput="this.value = this.value.toUpperCase()">
                    <p class="mt-1.5 text-xs text-sky-700">Minta kode ini kepada Agent Internal yang mengundang Anda.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap sesuai KTP"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm input-focus">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm input-focus">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm input-focus">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Min. 6 karakter"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12 text-sm input-focus">
                            <button type="button" onclick="togglePass('password','eye1')"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                <svg id="eye1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12 text-sm input-focus">
                            <button type="button" onclick="togglePass('password_confirmation','eye2')"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                <svg id="eye2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    class="btn-primary w-full rounded-xl py-3.5 text-sm font-semibold text-white">
                    Daftar Sebagai Agent Umum
                </button>
            </form>
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

@endsection