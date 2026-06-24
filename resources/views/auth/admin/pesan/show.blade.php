@extends('auth.layout.app')

@section('title', 'Detail Penilaian - ' . $pesan->nama_lengkap)

@section('content')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        brand: { 50: '#e6f1fb', 100: '#b5d4f4', 400: '#378add', 600: '#185fa5', 800: '#0c447c' }
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<div class="flex flex-col min-h-screen">

    <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('pesan.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-sm font-semibold text-slate-800">Detail Penilaian</h1>
                <p class="text-xs text-slate-400">{{ $pesan->nama_lengkap }} · {{ $pesan->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('pesan.toggle', $pesan->id) }}" method="POST" class="inline">
                @csrf @method('PATCH')
                <button type="submit"
                    class="flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-md border transition-colors
                        {{ $pesan->tampil ? 'border-teal-200 bg-teal-50 text-teal-700 hover:bg-teal-100' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                    <i class="ti ti-{{ $pesan->tampil ? 'eye' : 'eye-off' }} text-sm"></i>
                    {{ $pesan->tampil ? 'Ditampilkan' : 'Disembunyikan' }}
                </button>
            </form>
            <form action="{{ route('pesan.destroy', $pesan->id) }}" method="POST"
                onsubmit="return confirm('Hapus penilaian ini secara permanen?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-md border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                    <i class="ti ti-trash text-sm"></i> Hapus
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 p-6">
        <div class="max-w-2xl mx-auto space-y-5">

            @if(session('success'))
                <div class="rounded-lg border border-teal-100 bg-teal-50 px-4 py-3 text-sm text-teal-700">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile card -->
            <div class="bg-white rounded-xl border border-slate-100 px-6 py-5">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 text-base font-bold">
                        {{ $pesan->inisial }}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">{{ $pesan->nama_lengkap }}</p>
                        <p class="text-xs text-slate-400">{{ $pesan->email }}</p>
                    </div>
                    <div class="ml-auto">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full
                            {{ $pesan->tampil ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $pesan->tampil ? 'Ditampilkan' : 'Disembunyikan' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Rating</p>
                        <div class="flex items-center gap-1">
                            @for($s = 1; $s <= 5; $s++)
                                <i class="ti ti-star{{ $s <= $pesan->rating ? '-filled' : '' }} text-amber-400 text-base"></i>
                            @endfor
                            <span class="text-slate-600 text-xs ml-1">({{ $pesan->rating }}/5)</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Rekomendasi</p>
                        <p class="text-slate-700 font-medium">{{ $pesan->rekomendasi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Tanggal Submit</p>
                        <p class="text-slate-700">{{ $pesan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Fitur Favorit</p>
                        @if($pesan->fitur_favorit && count($pesan->fitur_favorit) > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($pesan->fitur_favorit as $fitur)
                                    <span class="text-[10px] bg-brand-50 text-brand-600 px-2 py-0.5 rounded-full font-medium">{{ $fitur }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-400 text-xs">Tidak dipilih</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Saran -->
            @if($pesan->saran)
                <div class="bg-white rounded-xl border border-slate-100 px-6 py-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-3">Saran & Masukan</p>
                    <blockquote class="text-slate-700 text-sm leading-relaxed italic border-l-4 border-brand-100 pl-4">
                        &ldquo;{{ $pesan->saran }}&rdquo;
                    </blockquote>
                </div>
            @endif

        </div>
    </main>
</div>

@endsection
