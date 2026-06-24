@extends('auth.layout.app')

@section('title', 'Data Kepuasan Agent')

@section('content')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        brand: {
                            50:  '#e6f1fb',
                            100: '#b5d4f4',
                            400: '#378add',
                            600: '#185fa5',
                            800: '#0c447c',
                        }
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<div class="flex flex-col min-h-screen">

    <!-- ── Topbar ── -->
    <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0 top-0 z-10">
        <div>
            <h1 class="text-sm font-semibold text-slate-800">Data Kepuasan Agent</h1>
            <p class="text-xs text-slate-400">Kelola testimonial & penilaian dari agent</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('informasi') }}" target="_blank"
               class="flex items-center gap-1.5 text-xs border border-slate-200 text-slate-600 px-3 py-1.5 rounded-md hover:bg-slate-50 transition-colors">
                <i class="ti ti-external-link text-sm" aria-hidden="true"></i>
                Lihat Halaman Publik
            </a>
        </div>
    </header>

    <!-- ── Page body ── -->
    <main class="flex-1 p-6 space-y-5">

        @if(session('success'))
            <div class="rounded-lg border border-teal-100 bg-teal-50 px-4 py-3 text-sm text-teal-700">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-lg border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <!-- ── Stats Bar ── -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Total Penilaian</p>
                <p class="text-2xl font-bold text-slate-800">{{ $pesans->total() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Ditampilkan</p>
                <p class="text-2xl font-bold text-teal-600">{{ $pesans->where('tampil', true)->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Disembunyikan</p>
                <p class="text-2xl font-bold text-slate-500">{{ $pesans->where('tampil', false)->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
                <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Halaman Ini</p>
                <p class="text-2xl font-bold text-brand-600">{{ $pesans->count() }}</p>
            </div>
        </div>

        <!-- ── Filter bar ── -->
        <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
            <form method="GET" action="{{ route('pesan.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="ti ti-search text-slate-400 text-sm absolute left-2.5 top-1/2 -translate-y-1/2" aria-hidden="true"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama / email…"
                        class="w-full text-xs pl-7 pr-3 py-2 border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-brand-400 placeholder-slate-400">
                </div>
                <select name="rating" class="text-xs text-slate-600 border border-slate-200 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-brand-400">
                    <option value="">Semua Rating</option>
                    @for($r = 5; $r >= 1; $r--)
                        <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>{{ $r }} ⭐</option>
                    @endfor
                </select>
                <button type="submit" class="flex items-center gap-1.5 text-xs bg-slate-800 text-white px-3 py-2 rounded-md hover:bg-slate-700 transition-colors">
                    <i class="ti ti-filter text-sm" aria-hidden="true"></i>
                    Filter
                </button>
                @if(request('search') || request('rating'))
                    <a href="{{ route('pesan.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline py-2">Reset</a>
                @endif
            </form>
        </div>

        <!-- ── Table ── -->
        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <p class="text-sm font-medium text-slate-800">Daftar Penilaian Kepuasan</p>
                <p class="text-xs text-slate-400">{{ $pesans->total() }} total entri</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Nama / Email</th>
                            <th class="text-center text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Rating</th>
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Saran</th>
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Rekomendasi</th>
                            <th class="text-center text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Tampil</th>
                            <th class="text-center text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Tanggal</th>
                            <th class="text-center text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($pesans as $p)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="font-medium text-slate-800">{{ $p->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $p->email }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-0.5">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="ti ti-star{{ $s <= $p->rating ? '-filled' : '' }} text-amber-400 text-xs"></i>
                                        @endfor
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $p->rating }}/5</p>
                                </td>
                                <td class="px-5 py-3.5 max-w-[200px]">
                                    <p class="text-slate-600 text-xs truncate" title="{{ $p->saran }}">
                                        {{ $p->saran ? Str::limit($p->saran, 80) : '-' }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($p->rekomendasi)
                                        <span class="inline-flex items-center text-xs font-medium px-2 py-0.5 rounded-full
                                            {{ $p->rekomendasi === 'Ya, pasti!' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $p->rekomendasi }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <form action="{{ route('pesan.toggle', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200
                                                {{ $p->tampil ? 'bg-teal-500' : 'bg-slate-300' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200
                                                {{ $p->tampil ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <p class="text-xs text-slate-500">{{ $p->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $p->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pesan.show', $p->id) }}"
                                            class="inline-flex items-center gap-1 text-xs border border-slate-200 text-slate-600 px-2 py-1 rounded hover:bg-slate-50 transition-colors">
                                            <i class="ti ti-eye text-xs"></i> Detail
                                        </a>
                                        <form action="{{ route('pesan.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus penilaian dari {{ $p->nama_lengkap }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 text-xs border border-red-200 text-red-600 px-2 py-1 rounded hover:bg-red-50 transition-colors">
                                                <i class="ti ti-trash text-xs"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-400 text-sm">
                                    <i class="ti ti-messages text-3xl block mb-2"></i>
                                    Belum ada data penilaian kepuasan agent.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pesans->hasPages())
                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $pesans->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </main>
</div>

@endsection
