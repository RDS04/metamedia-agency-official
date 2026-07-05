@extends('auth.layout.app')

@section('title', 'Daftar Mahasiswa Agent Luar')

@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Daftar Mahasiswa yang Didaftarkan Agent Luar
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Menampilkan mahasiswa yang terdaftar melalui agent luar yang memakai kode referral Anda.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('agen.Show') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                ← Kembali ke Daftar Agent
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-5">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Data Mahasiswa
                </h2>
                <p class="mt-1 text-sm text-sky-100">
                    Kode referral Anda: <span class="font-mono font-bold tracking-widest text-white">{{ $kodeReferral ?? '-' }}</span>
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-sky-100">Total</p>
                <p class="text-3xl font-extrabold text-white">{{ $mahasiswaCount }}</p>
            </div>
        </div>

        @if($mahasiswaCount > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">NIK</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No. HP</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Program Studi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Didaftarkan Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($mahasiswa as $index => $item)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $item->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->nik }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->nomor_hp }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->program_studi }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                        {{ $item->status ?? 'Prospek' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $item->agentLuar?->name ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-10 text-center text-sm text-slate-500">
                Belum ada mahasiswa yang didaftarkan melalui agent luar.
            </div>
        @endif
    </div>
</div>

@endsection
