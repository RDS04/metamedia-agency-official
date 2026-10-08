@extends('auth.layout.app')

@section('title', 'Detail Camaba')
@section('page-title', 'Detail Calon Mahasiswa')

@section('content')

    <div class="max-w-2xl">

        <a href="{{ route('agent-luar.camaba.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 mb-5 transition">
            <i class="ti ti-arrow-left text-base"></i>
            Kembali ke Daftar
        </a>

        @if(session('success'))
            <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-800">{{ $camaba->nama_lengkap }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">NIK/NIM: {{ $camaba->nik }}</p>
                </div>
                <span class="inline-flex items-center text-xs font-semibold px-3 py-1.5 rounded-full {{ $statusOptions[$camaba->status] ?? $statusOptions['Prospek'] }}">
                    {{ $camaba->status ?? 'Prospek' }}
                </span>
            </div>

            <!-- Data -->
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Nomor HP</p>
                    <p class="text-sm text-slate-800 font-semibold">{{ $camaba->nomor_hp }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Jenis Kelamin</p>
                    <p class="text-sm text-slate-800 font-semibold">{{ $camaba->jenis_kelamin }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Program Studi</p>
                    <p class="text-sm text-slate-800 font-semibold">{{ $camaba->program_studi }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Sistem Kuliah</p>
                    <p class="text-sm text-slate-800 font-semibold">{{ $camaba->sistem_kuliah }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Periode</p>
                    <p class="text-sm text-slate-800 font-semibold">{{ $camaba->periode }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Tanggal Didaftarkan</p>
                    <p class="text-sm text-slate-800 font-semibold">{{ $camaba->created_at->format('d M Y, H:i') }}</p>
                </div>

            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center gap-3">
                @if($camaba->status !== 'Registrasi Ulang')
                    <a href="{{ route('agent-luar.camaba.edit', $camaba->id) }}"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition flex items-center gap-1.5">
                        <i class="ti ti-pencil text-base"></i> Edit
                    </a>
                    <form action="{{ route('agent-luar.camaba.destroy', $camaba->id) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus data {{ $camaba->nama_lengkap }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition flex items-center gap-1.5">
                            <i class="ti ti-trash text-base"></i> Hapus
                        </button>
                    </form>
                @else
                    <span class="text-xs text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-2 rounded-lg">
                        ✓ Data sudah Registrasi Ulang — tidak dapat diubah
                    </span>
                @endif
                <a href="{{ route('agent-luar.camaba.index') }}"
                    class="px-4 py-2 border border-slate-200 text-slate-600 text-sm rounded-lg hover:bg-slate-100 transition">
                    Kembali
                </a>
            </div>

        </div>

    </div>

@endsection
