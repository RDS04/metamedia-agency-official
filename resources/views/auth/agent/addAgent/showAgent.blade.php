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
                Menampilkan agent luar yang terdaftar menggunakan kode referral Anda beserta mahasiswa yang didaftarkannya.
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
                            <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Mahasiswa Didaftarkan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Terdaftar</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($agentUmumList as $i => $au)
                            <tbody x-data="{ open: false }" class="border-b border-slate-100">
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $au->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $au->email }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $au->phone }}</td>
                                    <td class="px-6 py-4 text-sm font-mono font-semibold tracking-wider text-[#018FD7]">
                                        {{ $au->kode_referral ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700 border border-sky-200">
                                            🎓 {{ $au->camabas->count() }} Mahasiswa
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $au->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button @click="open = !open" type="button"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none">
                                            <span x-text="open ? 'Sembunyikan' : 'Detail Mahasiswa'">Detail Mahasiswa</span>
                                            <svg class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Expandable Row for Mahasiswa List brought by this Agent Luar --}}
                                <tr x-show="open" x-transition class="bg-sky-50/40">
                                    <td colspan="8" class="p-4 sm:p-6">
                                        <div class="rounded-xl border border-sky-100 bg-white p-4 shadow-sm">
                                            <div class="mb-3 flex items-center justify-between border-b border-slate-100 pb-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-sky-100 text-sky-700 font-bold text-xs">
                                                        {{ $i + 1 }}
                                                    </span>
                                                    <h3 class="text-sm font-bold text-slate-800">
                                                        Mahasiswa yang Didaftarkan oleh <span class="text-[#018FD7]">{{ $au->name }}</span>
                                                    </h3>
                                                </div>
                                                <span class="text-xs font-medium text-slate-500">
                                                    Total: <strong class="text-slate-800">{{ $au->camabas->count() }}</strong> calon mahasiswa
                                                </span>
                                            </div>

                                            @if($au->camabas->count() > 0)
                                                <div class="overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full text-left text-xs">
                                                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                                                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                                                                    <th class="px-4 py-2.5 font-semibold">No</th>
                                                                    <th class="px-4 py-2.5 font-semibold">Nama Mahasiswa</th>
                                                                    <th class="px-4 py-2.5 font-semibold">NIK / NIM</th>
                                                                    <th class="px-4 py-2.5 font-semibold">No. HP</th>
                                                                    <th class="px-4 py-2.5 font-semibold">Program Studi</th>
                                                                    <th class="px-4 py-2.5 font-semibold">Sistem Kuliah</th>
                                                                    <th class="px-4 py-2.5 font-semibold">Status</th>
                                                                    <th class="px-4 py-2.5 font-semibold">Tanggal Input</th>
                                                                    <th class="px-4 py-2.5 text-center font-semibold">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                                                @foreach($au->camabas as $mhsIndex => $mhs)
                                                                    @php
                                                                        $mhsStatusKey = $mhs->status ?? 'Prospek';
                                                                        $mhsStatusConfig = [
                                                                            'Prospek'          => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500', 'icon' => '⏳'],
                                                                            'Dihubungi'        => ['badge' => 'bg-cyan-50 text-cyan-700 border-cyan-200', 'dot' => 'bg-cyan-500', 'icon' => '📞'],
                                                                            'Sudah Daftar'     => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'dot' => 'bg-blue-500', 'icon' => '📝'],
                                                                            'Registrasi'       => ['badge' => 'bg-violet-50 text-violet-700 border-violet-200', 'dot' => 'bg-violet-500', 'icon' => '🏫'],
                                                                            'Registrasi Ulang' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500', 'icon' => '✅'],
                                                                            'Batal'            => ['badge' => 'bg-rose-50 text-rose-700 border-rose-200', 'dot' => 'bg-rose-500', 'icon' => '❌'],
                                                                        ];
                                                                        $mCfg = $mhsStatusConfig[$mhsStatusKey] ?? $mhsStatusConfig['Prospek'];
                                                                    @endphp
                                                                    <tr class="hover:bg-slate-50">
                                                                        <td class="px-4 py-2.5">{{ $mhsIndex + 1 }}</td>
                                                                        <td class="px-4 py-2.5 font-semibold text-[#018FD7]">{{ $mhs->nama_lengkap }}</td>
                                                                        <td class="px-4 py-2.5 font-mono">{{ $mhs->nik }}</td>
                                                                        <td class="px-4 py-2.5">{{ $mhs->nomor_hp }}</td>
                                                                        <td class="px-4 py-2.5">{{ $mhs->program_studi }}</td>
                                                                        <td class="px-4 py-2.5">{{ str_replace('_', ' ', $mhs->sistem_kuliah) }}</td>
                                                                        <td class="px-4 py-2.5">
                                                                            <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-[11px] font-bold shadow-2xs {{ $mCfg['badge'] }}">
                                                                                <span class="h-1.5 w-1.5 rounded-full {{ $mCfg['dot'] }} animate-pulse"></span>
                                                                                <span>{{ $mCfg['icon'] }}</span>
                                                                                <span>{{ $mhsStatusKey }}</span>
                                                                            </span>
                                                                        </td>
                                                                        <td class="px-4 py-2.5 text-slate-500">
                                                                            {{ $mhs->created_at ? $mhs->created_at->format('d M Y') : '-' }}
                                                                        </td>
                                                                        <td class="px-4 py-2.5 text-center">
                                                                            <a href="{{ route('agen.Detail', $mhs->id) }}"
                                                                                class="inline-flex items-center gap-1 rounded-lg bg-[#018FD7] px-2.5 py-1 text-[11px] font-semibold text-white transition hover:bg-[#0177BB]">
                                                                                Detail
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="py-6 text-center text-xs text-slate-500 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                                                    Agent umum ini belum mendaftarkan calon mahasiswa.
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
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

