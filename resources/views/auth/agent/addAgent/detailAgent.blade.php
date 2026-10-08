@extends('auth.layout.app')

@section('title', 'Detail Calon Mahasiswa')

@section('content')
@php
    $statusClass = $statusOptions[$agent->status] ?? 'bg-slate-100 text-slate-700';
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Detail Calon Mahasiswa</h1>
            <p class="mt-1 text-sm text-slate-500">Rincian data lengkap calon mahasiswa pendaftaran PMB</p>
        </div>

        <a href="{{ route('agen.ShowMahasiswa') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Mahasiswa
        </a>
    </div>

    <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20 text-2xl text-white backdrop-blur-md">
                    🎓
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $agent->nama_lengkap }}</h2>
                    <p class="mt-0.5 text-sm text-sky-100">Program Studi: <span class="font-semibold text-white">{{ $agent->program_studi }}</span></p>
                </div>
            </div>

            <div>
                <span class="inline-flex items-center rounded-full px-3.5 py-1.5 text-xs font-bold shadow-sm {{ $statusClass }}">
                    {{ $agent->status ?? 'Prospek' }}
                </span>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400">Informasi Pribadi & Pendaftaran</h3>
            
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Lengkap</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ $agent->nama_lengkap }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">NIK / NIM</p>
                    <p class="mt-1 text-base font-mono font-bold text-slate-800">{{ $agent->nik }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nomor HP / WhatsApp</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ $agent->nomor_hp }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Jenis Kelamin</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ $agent->jenis_kelamin }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Program Studi Pilihan</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ $agent->program_studi }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sistem Kuliah</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ str_replace('_', ' ', $agent->sistem_kuliah) }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Periode PMB</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ $agent->periode ?? '-' }}</p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Didaftarkan Oleh</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        @if($agent->agent_luar_id && $agent->agentLuar)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700 border border-purple-200">
                                🏢 Agent Luar: {{ $agent->agentLuar->name }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 border border-sky-200">
                                👤 Agent: {{ $agent->agent->name ?? Auth::user()->name }}
                            </span>
                        @endif
                    </p>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal Input Data</p>
                    <p class="mt-1 text-base font-bold text-slate-800">{{ $agent->created_at ? $agent->created_at->format('d M Y, H:i WIB') : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <a href="{{ route('agen.ShowMahasiswa') }}"
                class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">
                Kembali
            </a>

            @if($agent->agent_id == Auth::id() && $agent->status !== 'Registrasi Ulang')
                <a href="{{ route('agen.Edit', $agent->id) }}"
                    class="rounded-xl bg-[#018FD7] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0177BB]">
                    Edit Data Mahasiswa
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
