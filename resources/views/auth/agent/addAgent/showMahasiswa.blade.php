@extends('auth.layout.app')

@section('title', 'Daftar Mahasiswa')

@section('content')

@php
    $statusConfig = [
        'Prospek'          => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200/80', 'dot' => 'bg-amber-500', 'icon' => '⏳'],
        'Dihubungi'        => ['badge' => 'bg-cyan-50 text-cyan-700 border-cyan-200/80', 'dot' => 'bg-cyan-500', 'icon' => '📞'],
        'Sudah Daftar'     => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200/80', 'dot' => 'bg-blue-500', 'icon' => '📝'],
        'Registrasi'       => ['badge' => 'bg-violet-50 text-violet-700 border-violet-200/80', 'dot' => 'bg-violet-500', 'icon' => '🏫'],
        'Registrasi Ulang' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80', 'dot' => 'bg-emerald-500', 'icon' => '✅'],
        'Batal'            => ['badge' => 'bg-rose-50 text-rose-700 border-rose-200/80', 'dot' => 'bg-rose-500', 'icon' => '❌'],
    ];
@endphp

<div class="space-y-6" x-data="{ showModal: false, detail: {}, search: '', filterStatus: '' }">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                Daftar Mahasiswa
            </h1>
            <p class="mt-1 text-sm font-medium text-slate-500">
                Menampilkan seluruh calon mahasiswa yang Anda daftarkan langsung maupun melalui Agent Luar binaan Anda.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('agen.Create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-sky-500/25 transition-all hover:scale-[1.02] hover:shadow-sky-500/35">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Mahasiswa Baru
            </a>
            <a href="{{ route('agen.Show') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200/90 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-xs transition-all hover:bg-slate-50 hover:text-slate-900">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Daftar Agent Luar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm font-semibold text-emerald-800 shadow-sm">
            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500 text-white font-bold">✓</span>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50/90 p-4 text-sm font-semibold text-rose-800 shadow-sm">
            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-rose-500 text-white font-bold">!</span>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Main Table Container -->
    <div class="overflow-hidden rounded-[24px] border border-slate-200/80 bg-white shadow-md shadow-slate-200/50">
        
        <!-- Header Banner -->
        <div class="flex flex-col gap-4 border-b border-slate-200/80 bg-gradient-to-r from-[#018FD7] via-[#0177BB] to-[#0165A3] px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-white">
                    Data Mahasiswa
                </h2>
                <div class="mt-1 flex items-center gap-2">
                    <span class="text-xs font-medium text-sky-100">Kode Referral Anda:</span>
                    <span class="rounded-lg bg-white/20 px-2.5 py-0.5 font-mono text-xs font-extrabold tracking-widest text-white backdrop-blur-md border border-white/30">
                        {{ $kodeReferral ?? '-' }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="rounded-2xl bg-white/10 px-5 py-2.5 backdrop-blur-md border border-white/20 text-center">
                    <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-sky-100">Total Mahasiswa</p>
                    <p class="text-3xl font-extrabold text-white">{{ $mahasiswaCount }}</p>
                </div>
            </div>
        </div>

        @if($mahasiswaCount > 0)
            <!-- Search & Filter Bar -->
            <div class="flex flex-col gap-3 border-b border-slate-100 bg-slate-50/60 p-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative w-full sm:w-80">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input x-model="search" type="text" placeholder="Cari nama, NIK/NIM, HP..." 
                        class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 shadow-2xs focus:border-[#018FD7] focus:outline-none focus:ring-2 focus:ring-[#018FD7]/20 transition" />
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 whitespace-nowrap">Filter Status:</span>
                    <select x-model="filterStatus" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-2xs focus:border-[#018FD7] focus:outline-none transition">
                        <option value="">Semua Status</option>
                        <option value="Prospek">Prospek</option>
                        <option value="Dihubungi">Dihubungi</option>
                        <option value="Sudah Daftar">Sudah Daftar</option>
                        <option value="Registrasi">Registrasi</option>
                        <option value="Registrasi Ulang">Registrasi Ulang</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/80 bg-slate-50/90 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="px-5 py-3.5 text-center w-12">No</th>
                            <th class="px-5 py-3.5">Nama Lengkap</th>
                            <th class="px-5 py-3.5">NIK / NIM</th>
                            <th class="px-5 py-3.5">No. HP</th>
                            <th class="px-5 py-3.5">Program Studi</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Didaftarkan Oleh</th>
                            <th class="px-5 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($mahasiswa as $index => $item)
                            @php
                                $statusKey = $item->status ?? 'Prospek';
                                $cfg = $statusConfig[$statusKey] ?? $statusConfig['Prospek'];
                                $initial = strtoupper(substr($item->nama_lengkap ?? 'M', 0, 1));
                            @endphp
                            <tr class="transition-colors hover:bg-sky-50/50 cursor-pointer"
                                x-show="(search === '' || '{{ strtolower(addslashes($item->nama_lengkap)) }}'.includes(search.toLowerCase()) || '{{ $item->nik }}'.includes(search) || '{{ $item->nomor_hp }}'.includes(search)) && (filterStatus === '' || '{{ $statusKey }}' === filterStatus)"
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
                                
                                {{-- Index --}}
                                <td class="px-5 py-4 text-center text-xs font-bold text-slate-400">
                                    {{ $index + 1 }}
                                </td>
                                
                                {{-- Nama --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#018FD7] to-[#0165A3] text-sm font-extrabold text-white shadow-xs">
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 hover:text-[#018FD7] transition">
                                                {{ $item->nama_lengkap }}
                                            </p>
                                            <p class="text-[11px] font-medium text-slate-400">
                                                {{ $item->jenis_kelamin }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- NIM --}}
                                <td class="px-5 py-4">
                                    <span class="inline-block rounded-xl bg-slate-100/90 px-3 py-1 font-mono text-xs font-bold text-slate-800 border border-slate-200/80 shadow-2xs">
                                        {{ $item->nik }}
                                    </span>
                                </td>

                                {{-- No HP --}}
                                <td class="px-5 py-4 text-xs font-bold text-slate-800">
                                    {{ $item->nomor_hp }}
                                </td>

                                {{-- Prodi --}}
                                <td class="px-5 py-4">
                                    <p class="text-xs font-bold text-slate-900">{{ $item->program_studi }}</p>
                                    <p class="text-[11px] font-medium text-slate-400">{{ str_replace('_', ' ', $item->sistem_kuliah) }}</p>
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-extrabold shadow-2xs {{ $cfg['badge'] }}">
                                        <span class="h-2 w-2 rounded-full {{ $cfg['dot'] }} animate-pulse"></span>
                                        <span class="text-xs">{{ $cfg['icon'] }}</span>
                                        <span>{{ $statusKey }}</span>
                                    </span>
                                </td>

                                {{-- Didaftarkan Oleh --}}
                                <td class="px-5 py-4">
                                    @if($item->agent_luar_id && $item->agentLuar)
                                        <div class="inline-flex items-center gap-2 rounded-xl bg-purple-50/90 border border-purple-200/80 px-3 py-1.5 shadow-2xs">
                                            <span class="text-sm">🏢</span>
                                            <div>
                                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-purple-700 leading-tight">Agent Luar</p>
                                                <p class="text-xs font-bold text-purple-900 leading-tight">{{ $item->agentLuar->name }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-2 rounded-xl bg-sky-50/90 border border-sky-200/80 px-3 py-1.5 shadow-2xs">
                                            <span class="text-sm">👤</span>
                                            <div>
                                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-sky-700 leading-tight">Agent Internal</p>
                                                <p class="text-xs font-bold text-sky-900 leading-tight">{{ $item->agent->name ?? Auth::user()->name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4 text-center" @click.stop>
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
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-[#018FD7] px-3.5 py-1.5 text-xs font-bold text-white shadow-xs transition hover:bg-[#0177BB] active:scale-95">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </button>

                                        @if($item->agent_id == Auth::id() && $item->status !== 'Registrasi Ulang')
                                            <a href="{{ route('agen.Edit', $item->id) }}"
                                                class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-bold text-slate-700 shadow-2xs transition hover:bg-slate-50 hover:border-slate-300 active:scale-95">
                                                <svg class="h-3.5 w-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            <div class="px-6 py-14 text-center text-sm text-slate-500">
                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-3xl shadow-xs">
                    🎓
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Mahasiswa</h3>
                <p class="mt-1 text-xs text-slate-500">Silakan gunakan tombol di bawah untuk mendaftarkan calon mahasiswa baru.</p>
                <div class="mt-4">
                    <a href="{{ route('agen.Create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#018FD7] px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-[#0177BB] transition">
                        + Tambah Mahasiswa Baru
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Detail Mahasiswa -->
    <div x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm"
        style="display: none;">
        
        <div @click.away="showModal = false"
            class="w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl transition-all">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-[#018FD7] to-[#0177BB] px-6 py-5">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-xl text-white backdrop-blur-md shadow-xs">
                        🎓
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-white" x-text="detail.nama">Detail Mahasiswa</h3>
                        <p class="text-xs font-medium text-sky-100" x-text="'Prodi: ' + detail.prodi"></p>
                    </div>
                </div>
                <button @click="showModal = false" class="rounded-xl p-1.5 text-white/80 hover:bg-white/20 hover:text-white transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Lengkap</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.nama"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">NIK / NIM</p>
                        <p class="mt-1 text-sm font-mono font-bold text-slate-800" x-text="detail.nik"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor HP / WhatsApp</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.phone"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Jenis Kelamin</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.jk"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Program Studi</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.prodi"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sistem Kuliah</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.sistem"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Periode PMB</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.periode"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Pendaftaran</p>
                        <span class="mt-1 inline-flex items-center gap-1.5 rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-bold text-sky-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                            <span x-text="detail.status"></span>
                        </span>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Didaftarkan Oleh</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.by"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Input</p>
                        <p class="mt-1 text-sm font-bold text-slate-800" x-text="detail.date"></p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button @click="showModal = false" type="button" class="rounded-xl border border-slate-300 bg-white px-5 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 transition">
                    Tutup
                </button>
                <a :href="detail.detailUrl" class="rounded-xl border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-bold text-sky-700 hover:bg-sky-100 transition">
                    Halaman Detail ↗
                </a>
                <template x-if="detail.canEdit">
                    <a :href="detail.editUrl" class="rounded-xl bg-[#018FD7] px-5 py-2 text-sm font-bold text-white hover:bg-[#0177BB] transition">
                        Edit Data
                    </a>
                </template>
            </div>
        </div>
    </div>
</div>

@endsection


