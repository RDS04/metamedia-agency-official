@extends('auth.layout.app')

@section('title', 'Daftar Camaba')
@section('page-title', 'Daftar Camaba')

@section('content')

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 text-center">
            <p class="text-xs text-slate-400">Total</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalCamaba }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 text-center">
            <p class="text-xs text-slate-400">Prospek</p>
            <p class="text-2xl font-bold text-amber-600">{{ $prospek }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 text-center">
            <p class="text-xs text-slate-400">Sudah Daftar</p>
            <p class="text-2xl font-bold text-blue-600">{{ $sudahDaftar }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 text-center">
            <p class="text-xs text-slate-400">Reg. Ulang</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $registrasiUlang }}</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">

        <!-- Toolbar -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-slate-100">
            <p class="text-sm font-medium text-slate-800">Semua Camaba</p>

            <div class="flex flex-wrap items-center gap-2">
                <!-- Search -->
                <form method="GET" action="{{ route('agent-luar.camaba.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama / NIK / NIM..."
                        class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100">

                    <select name="status" class="px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-[#018FD7] bg-white">
                        <option value="">Semua Status</option>
                        @foreach(array_keys($statusOptions) as $st)
                            <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm transition">
                        Filter
                    </button>

                    @if(request()->hasAny(['search','status']))
                        <a href="{{ route('agent-luar.camaba.index') }}" class="px-3 py-2 text-sm text-red-500 border border-red-100 rounded-lg hover:bg-red-50 transition">
                            Reset
                        </a>
                    @endif
                </form>

                <a href="{{ route('agent-luar.camaba.create') }}"
                    class="flex items-center gap-1.5 px-4 py-2 bg-[#018FD7] hover:bg-[#0073b1] text-white text-xs font-semibold rounded-lg transition">
                    <i class="ti ti-plus text-sm"></i>
                    Tambah
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">#</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Nama</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Program Studi</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Sistem Kuliah</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Periode</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Status</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($camabas as $maba)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $camabas->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-3.5 text-slate-800 font-medium">
                                {{ $maba->nama_lengkap }}
                                <p class="text-xs text-slate-400 font-normal">{{ $maba->nomor_hp }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $maba->program_studi }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $maba->sistem_kuliah }}</td>
                            <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $maba->periode }}</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full {{ $statusOptions[$maba->status] ?? $statusOptions['Prospek'] }}">
                                    {{ $maba->status ?? 'Prospek' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('agent-luar.camaba.show', $maba->id) }}"
                                        class="text-xs text-slate-400 hover:text-[#018FD7] transition" title="Lihat">
                                        <i class="ti ti-eye text-base"></i>
                                    </a>
                                    @if($maba->status !== 'Registrasi Ulang')
                                        <a href="{{ route('agent-luar.camaba.edit', $maba->id) }}"
                                            class="text-xs text-slate-400 hover:text-amber-500 transition" title="Edit">
                                            <i class="ti ti-pencil text-base"></i>
                                        </a>
                                        <form action="{{ route('agent-luar.camaba.destroy', $maba->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus data {{ $maba->nama_lengkap }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-slate-400 hover:text-red-500 transition" title="Hapus">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Belum ada data camaba.
                                <br>
                                <a href="{{ route('agent-luar.camaba.create') }}" class="text-[#018FD7] hover:underline text-sm mt-1 inline-block">
                                    Tambah camaba pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-400">
                Menampilkan {{ $camabas->firstItem() ?? 0 }}–{{ $camabas->lastItem() ?? 0 }} dari {{ $camabas->total() }} data
            </p>
            {{ $camabas->links() }}
        </div>
    </div>

@endsection
