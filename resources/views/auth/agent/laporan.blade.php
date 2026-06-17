

@extends('auth.layout.app')

@section('title', 'Laporan')

@section('page-title', 'Laporan')

@section('content')

<!-- Metric cards -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Total Camaba</p>
        <p class="text-3xl font-semibold text-slate-800 leading-none">{{ $totalCamaba }}</p>
        <p class="text-xs text-slate-400 mt-2">Seluruh data calon mahasiswa</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Sudah Daftar</p>
        <p class="text-3xl font-semibold text-teal-600 leading-none">{{ $sudahDaftar }}</p>
        <p class="text-xs text-slate-400 mt-2">Mengisi formulir PMB</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Registrasi Ulang</p>
        <p class="text-3xl font-semibold text-amber-600 leading-none">{{ $registrasiUlang }}</p>
        <p class="text-xs text-slate-400 mt-2">Menjadi mahasiswa aktif</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Total Bonus</p>
        <p class="text-xl font-semibold text-violet-600 leading-none mt-1">Rp {{ number_format($totalBonus, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-2">Bonus berjalan</p>
    </div>
</div>

<!-- Progress + Bonus -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    <!-- Progress funnel -->
    <div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-5">
            <p class="text-sm font-medium text-slate-800">Progress PMB</p>
            <span class="text-xs text-slate-400">Konversi prospek ke aktif</span>
        </div>
        <div class="space-y-5">
            <!-- Prospek -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-xs text-slate-500">Prospek</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400">{{ $progress['prospek']['percent'] }}%</span>
                        <span class="text-xs font-medium text-slate-800">{{ $progress['prospek']['count'] }}</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-blue-400 h-2 rounded-full" style="width:{{ $progress['prospek']['percent'] }}%"></div>
                </div>
            </div>
            <!-- Sudah Daftar -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-xs text-slate-500">Sudah Daftar</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400">{{ $progress['sudah_daftar']['percent'] }}%</span>
                        <span class="text-xs font-medium text-teal-600">{{ $progress['sudah_daftar']['count'] }}</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-teal-500 h-2 rounded-full" style="width:{{ $progress['sudah_daftar']['percent'] }}%"></div>
                </div>
            </div>
            <!-- Registrasi Ulang -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-xs text-slate-500">Registrasi Ulang</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400">{{ $progress['registrasi_ulang']['percent'] }}%</span>
                        <span class="text-xs font-medium text-amber-600">{{ $progress['registrasi_ulang']['count'] }}</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width:{{ $progress['registrasi_ulang']['percent'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Conversion note -->
        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-6">
            <div class="text-center">
                <p class="text-xs text-slate-400">Tingkat daftar</p>
                <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ number_format($tingkatDaftar, 1, ',', '.') }}%</p>
            </div>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="text-center">
                <p class="text-xs text-slate-400">Tingkat registrasi</p>
                <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ number_format($tingkatRegistrasi, 1, ',', '.') }}%</p>
            </div>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="text-center">
                <p class="text-xs text-slate-400">Konversi total</p>
                <p class="text-sm font-semibold text-teal-600 mt-0.5">{{ number_format($konversiTotal, 1, ',', '.') }}%</p>
            </div>
        </div>
    </div>

    <!-- Bonus card -->
    <div class="bg-white rounded-xl border border-slate-100 p-5 flex flex-col justify-between">
        <p class="text-sm font-medium text-slate-800 mb-4">Rincian Bonus</p>

        <div class="bg-slate-50 rounded-lg px-4 py-4 mb-4">
            <p class="text-xs text-slate-400 mb-1">Total bonus berjalan</p>
            <p class="text-2xl font-semibold text-violet-600">Rp {{ number_format($totalBonus, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1.5">{{ $registrasiUlang }} registrasi x Rp {{ number_format($bonusPerRegistrasi, 0, ',', '.') }}</p>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Bonus per registrasi</span>
                <span class="font-medium text-slate-800">Rp {{ number_format($bonusPerRegistrasi, 0, ',', '.') }}</span>
            </div>
            <hr class="border-slate-100">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Registrasi ulang</span>
                <span class="font-medium text-amber-600">{{ $registrasiUlang }} mahasiswa</span>
            </div>
            <hr class="border-slate-100">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Status pencairan</span>
                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Menunggu</span>
            </div>
        </div>

        <button class="mt-5 w-full flex items-center justify-center gap-2 text-xs text-blue-600 border border-blue-100 bg-blue-50 px-3 py-2 rounded-md hover:bg-blue-100 transition-colors">
            <i class="ti ti-file-invoice text-sm" aria-hidden="true"></i>
            Ajukan pencairan
        </button>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <p class="text-sm font-medium text-slate-800">Detail Camaba</p>
        <form method="GET" action="{{ route('laporan') }}" class="flex items-center gap-2">
            <div class="relative">
                <i class="ti ti-search text-slate-400 text-sm absolute left-2.5 top-1/2 -translate-y-1/2" aria-hidden="true"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="text-xs pl-7 pr-3 py-1.5 border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 w-40">
            </div>
            <select name="status" class="text-xs text-slate-600 border border-slate-200 rounded-md px-2.5 py-1.5 bg-white focus:outline-none">
                <option value="">Semua status</option>
                <option value="Prospek" selected>Prospek</option>
            </select>
            <button type="submit" class="text-xs text-blue-600 border border-blue-100 bg-blue-50 px-3 py-1.5 rounded-md hover:bg-blue-100 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('laporan') }}" class="text-xs text-slate-500 border border-slate-200 px-3 py-1.5 rounded-md hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Nama</th>
                    <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Program Studi</th>
                    <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Sistem</th>
                    <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Tgl Daftar</th>
                    <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Status</th>
                    <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Bonus</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($camaba as $maba)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">{{ $maba->nama_lengkap }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $maba->program_studi }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $maba->sistem_kuliah }}</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $maba->created_at?->format('d M Y') ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Prospek</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">-</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                        Belum ada data camaba.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-400">
            Menampilkan {{ $camaba->firstItem() ?? 0 }} sampai {{ $camaba->lastItem() ?? 0 }} dari {{ $camaba->total() }} camaba
        </p>
        <div>
            {{ $camaba->links() }}
        </div>
    </div>
</div>

@endsection

