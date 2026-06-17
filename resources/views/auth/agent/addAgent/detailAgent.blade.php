@extends('auth.layout.app')

@section('title', 'Detail Calon Mahasiswa')

@section('content')
@php
    $statusClass = $statusOptions[$agent->status] ?? $statusOptions['Prospek'];
@endphp

<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-black">Detail Calon Mahasiswa</h1>
            <p class="text-gray-400 mt-1">Rincian data calon mahasiswa yang Anda daftarkan</p>
        </div>

        <a href="{{ route('dashboard') }}"
            class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-[#018FD7] to-[#0177BB]">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h2 class="text-white text-lg font-semibold">{{ $agent->nama_lengkap }}</h2>
                    <p class="text-blue-100 text-sm mt-1">{{ $agent->program_studi }}</p>
                </div>

                <span class="inline-flex w-fit items-center text-xs font-medium px-3 py-1 rounded-full {{ $statusClass }}">
                    {{ $agent->status ?? 'Prospek' }}
                </span>
            </div>
        </div>

        <div class="p-6 grid md:grid-cols-2 gap-5">
            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Nama Lengkap</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->nama_lengkap }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">NIK</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->nik }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Nomor HP</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->nomor_hp }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Jenis Kelamin</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->jenis_kelamin }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Program Studi</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->program_studi }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Sistem Kuliah</p>
                <p class="text-sm font-semibold text-gray-800">{{ str_replace('_', ' ', $agent->sistem_kuliah) }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Periode</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->periode ?? '-' }}</p>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                <p class="text-xs text-gray-400 mb-1">Tanggal Input</p>
                <p class="text-sm font-semibold text-gray-800">{{ $agent->created_at?->format('d M Y H:i') ?? '-' }}</p>
            </div>
        </div>

        <div class="px-6 py-4 border-t bg-gray-50 flex flex-wrap justify-end gap-3">
            <a href="{{ route('laporan') }}"
                class="px-5 py-2 bg-white border border-gray-200 hover:bg-gray-100 text-gray-700 rounded-lg font-medium transition">
                Lihat Laporan
            </a>

            @if($agent->status !== 'Registrasi Ulang')
                <a href="{{ route('agen.Edit', $agent->id) }}"
                    class="px-5 py-2 bg-[#018FD7] hover:bg-[#0177BB] text-white rounded-lg font-medium transition">
                    Edit Data
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
