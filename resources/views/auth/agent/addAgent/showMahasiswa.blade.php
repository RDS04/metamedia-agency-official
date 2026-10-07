@extends('auth.layout.app')

@section('title', 'Daftar Mahasiswa')

@section('content')

@php
    $statusConfig = [
        'Prospek'          => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500', 'icon' => '⏳'],
        'Dihubungi'        => ['badge' => 'bg-cyan-50 text-cyan-700 border-cyan-200', 'dot' => 'bg-cyan-500', 'icon' => '📞'],
        'Sudah Daftar'     => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'dot' => 'bg-blue-500', 'icon' => '📝'],
        'Registrasi'       => ['badge' => 'bg-violet-50 text-violet-700 border-violet-200', 'dot' => 'bg-violet-500', 'icon' => '🏫'],
        'Registrasi Ulang' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500', 'icon' => '✅'],
        'Batal'            => ['badge' => 'bg-rose-50 text-rose-700 border-rose-200', 'dot' => 'bg-rose-500', 'icon' => '❌'],
    ];
@endphp

<div class="space-y-6" x-data="{ showModal: false, detail: {} }">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Daftar Mahasiswa
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Menampilkan seluruh mahasiswa yang Anda daftarkan langsung maupun melalui Agent Luar binaan Anda.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('agen.Create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-sky-500/20 transition hover:opacity-95">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Mahasiswa Baru
            </a>
            <a href="{{ route('agen.Show') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                ← Daftar Agent Luar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700 shadow-sm">
            <span>✅</span>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700 shadow-sm">
            <span>⚠️</span>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-5">
            <div>
                <h2 class="text-lg font-bold text-white">
                    Data Mahasiswa
                </h2>
                <p class="mt-1 text-sm text-sky-100">
                    Kode referral Anda: <span class="font-mono font-bold tracking-widest text-white">{{ $kodeReferral ?? '-' }}</span>
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs uppercase tracking-[0.2em] text-sky-100 font-semibold">Total Mahasiswa</p>
                <p class="text-3xl font-extrabold text-white">{{ $mahasiswaCount }}</p>
            </div>
        </div>

        @if($mahasiswaCount > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-slate-200 bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">NIK</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Program Studi</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Didaftarkan Oleh</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($mahasiswa as $index => $item)
                            @php
                                $statusKey = $item->status ?? 'Prospek';
                                $cfg = $statusConfig[$statusKey] ?? $statusConfig['Prospek'];
                                $initial = strtoupper(substr($item->nama_lengkap ?? 'M', 0, 1));
                            @endphp
                            <tr class="transition hover:bg-sky-50/40 cursor-pointer"
                                @click="detail = {
                                    id: '{{ $item->id }}',
                                    nama: '{{ addslashes($item->nama_lengkap) }}',
                                    nik: '{{ $item->nik }}',
                                    phone: '{{ $item->nomor_hp }}',
                                    jk: '{{ $item->jenis_kelamin }}',
                                    prodi: '{{ $item->program_studi }}',
                                    sistem: '{{ str_replace('_', ' ', $item->sistem_kuliah) }}',
                                    periode: '{{ $item->periode }}',
                                    status: '{{ $item->status ?? 'Prospek' }}',
                                    by: '{{ $item->agent_luar_id && $item->agentLuar ? 'Agent Luar: ' . addslashes($item->agentLuar->name) : 'Agent: ' . addslashes($item->agent->name ?? Auth::user()->name) }}',
                                    date: '{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}',
                                    canEdit: {{ ($item->agent_id == Auth::id() && $item->status !== 'Registrasi Ulang') ? 'true' : 'false' }},
                                    detailUrl: '{{ route('agen.Detail', $item->id) }}',
                                    editUrl: '{{ route('agen.Edit', $item->id) }}'
                                }; showModal = true">
                                
                                <td class="px-6 py-4 text-sm font-semibold text-slate-500">{{ $index + 1 }}</td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-[#018FD7] to-[#0177BB] text-xs font-bold text-white shadow-xs">
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 hover:text-[#018FD7] transition">
                                                {{ $item->nama_lengkap }}
                                            </p>
                                            <p class="text-[11px] text-slate-400">
                                                {{ $item->jenis_kelamin }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-mono font-semibold text-slate-700 border border-slate-200/60">
                                        {{ $item->nik }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                    {{ $item->nomor_hp }}
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-800">{{ $item->program_studi }}</p>
                                    <p class="text-[11px] text-slate-400">{{ str_replace('_', ' ', $item->sistem_kuliah) }}</p>
                                </td>

                                {{-- Status Badge Column --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-bold shadow-2xs {{ $cfg['badge'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $cfg['dot'] }} animate-pulse"></span>
                                        <span class="text-[11px]">{{ $cfg['icon'] }}</span>
                                        <span>{{ $statusKey }}</span>
                                    </span>
                                </td>

                                {{-- Didaftarkan Oleh Column --}}
                                <td class="px-6 py-4">
                                    @if($item->agent_luar_id && $item->agentLuar)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 border border-purple-200/80 px-3 py-1 text-xs font-semibold text-purple-700 shadow-2xs">
                                            🏢 Agent Luar: {{ $item->agentLuar->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 border border-sky-200/80 px-3 py-1 text-xs font-semibold text-sky-700 shadow-2xs">
                                            👤 Agent: {{ $item->agent->name ?? Auth::user()->name }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center" @click.stop>
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            @click="detail = {
                                                id: '{{ $item->id }}',
                                                nama: '{{ addslashes($item->nama_lengkap) }}',
                                                nik: '{{ $item->nik }}',
                                                phone: '{{ $item->nomor_hp }}',
                                                jk: '{{ $item->jenis_kelamin }}',
                                                prodi: '{{ $item->program_studi }}',
                                                sistem: '{{ str_replace('_', ' ', $item->sistem_kuliah) }}',
                                                periode: '{{ $item->periode }}',
                                                status: '{{ $item->status ?? 'Prospek' }}',
                                                by: '{{ $item->agent_luar_id && $item->agentLuar ? 'Agent Luar: ' . addslashes($item->agentLuar->name) : 'Agent: ' . addslashes($item->agent->name ?? Auth::user()->name) }}',
                                                date: '{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}',
                                                canEdit: {{ ($item->agent_id == Auth::id() && $item->status !== 'Registrasi Ulang') ? 'true' : 'false' }},
                                                detailUrl: '{{ route('agen.Detail', $item->id) }}',
                                                editUrl: '{{ route('agen.Edit', $item->id) }}'
                                            }; showModal = true"
                                            type="button"
                                            class="inline-flex items-center gap-1 rounded-xl bg-[#018FD7] px-3 py-1.5 text-xs font-semibold text-white shadow-xs transition hover:bg-[#0177BB]">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </button>

                                        <a :href="'{{ route('agen.Detail', $item->id) }}'"
                                            class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs transition hover:bg-slate-100"
                                            title="Halaman Detail">
                                            🔍
                                        </a>

                                        @if($item->agent_id == Auth::id() && $item->status !== 'Registrasi Ulang')
                                            <a href="{{ route('agen.Edit', $item->id) }}"
                                                class="inline-flex items-center gap-1 rounded-xl border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-2xs transition hover:bg-slate-100">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center text-sm text-slate-500">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                    🎓
                </div>
                Belum ada mahasiswa yang terdaftar. Silakan gunakan menu <a href="{{ route('agen.Create') }}" class="font-bold text-[#018FD7] hover:underline">Tambah Mahasiswa Baru</a> untuk menginputkan mahasiswa.
            </div>
        @endif
    </div>

    <!-- Modal Detail Mahasiswa -->
    <div x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm"
        style="display: none;">
        
        <div @click.away="showModal = false"
            class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white backdrop-blur-md">
                        🎓
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white" x-text="detail.nama">Detail Mahasiswa</h3>
                        <p class="text-xs text-sky-100" x-text="'Prodi: ' + detail.prodi"></p>
                    </div>
                </div>
                <button @click="showModal = false" class="rounded-lg p-1 text-white/80 hover:bg-white/20 hover:text-white transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Lengkap</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.nama"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">NIK</p>
                        <p class="mt-1 text-sm font-mono font-bold text-slate-800" x-text="detail.nik"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nomor HP / WhatsApp</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.phone"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Jenis Kelamin</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.jk"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Program Studi</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.prodi"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sistem Kuliah</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.sistem"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Periode PMB</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.periode"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Status Pendaftaran</p>
                        <span class="mt-1 inline-flex items-center gap-1.5 rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-bold text-sky-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                            <span x-text="detail.status"></span>
                        </span>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Didaftarkan Oleh</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.by"></p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal Input</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.date"></p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button @click="showModal = false" type="button" class="rounded-xl border border-slate-300 bg-white px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                    Tutup
                </button>
                <a :href="detail.detailUrl" class="rounded-xl border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700 hover:bg-sky-100 transition">
                    Halaman Detail ↗
                </a>
                <template x-if="detail.canEdit">
                    <a :href="detail.editUrl" class="rounded-xl bg-[#018FD7] px-5 py-2 text-sm font-semibold text-white hover:bg-[#0177BB] transition">
                        Edit Data
                    </a>
                </template>
            </div>
        </div>
    </div>
</div>

@endsection


