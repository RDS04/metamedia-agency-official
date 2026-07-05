@extends('auth.layout.app')

@section('title', 'Daftar Agent Luar')

@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Daftar Agent Luar
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Menampilkan agent luar yang terdaftar menggunakan kode referral Anda.
            </p>
        </div>

        <a href="{{ route('agen.ShowMahasiswa') }}"
            class="inline-flex items-center justify-center rounded-xl bg-[#018FD7] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0177BB]">
            Lihat Daftar Mahasiswa
        </a>
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
        <div class="flex flex-col gap-4 border-b border-slate-200 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Agent Umum yang Mendaftar via Kode Referral Anda
                </h2>
                <p class="mt-1 text-sm text-sky-100">
                    Kode referral Anda: <span class="font-mono font-bold tracking-widest text-white">{{ $kodeReferral ?? '-' }}</span>
                </p>
            </div>

            <div class="text-left lg:text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-sky-100">Total Agent Umum</p>
                <p class="text-3xl font-extrabold text-white">{{ $agentUmumCount }}</p>
            </div>
        </div>

        @if($agentUmumCount > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama Agent Umum</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No. HP</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Kode Referral</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($agentUmumList as $i => $au)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $au->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $au->email }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $au->phone }}</td>
                                <td class="px-6 py-4 text-sm font-mono font-semibold tracking-wider text-[#018FD7]">
                                    {{ $au->kode_referral ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $au->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center text-sm text-slate-500">
                Belum ada Agent Umum yang mendaftar menggunakan kode referral Anda.
            </div>
        @endif
    </div>
</div>

@endsection
