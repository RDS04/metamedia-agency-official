

@extends('auth.layout.app')

@section('title', 'Laporan')

@section('page-title', 'Laporan')

@section('content')

<!-- Metric cards -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Total Camaba</p>
        <p class="text-3xl font-semibold text-slate-800 leading-none">24</p>
        <p class="text-xs text-slate-400 mt-2">Seluruh data calon mahasiswa</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Sudah Daftar</p>
        <p class="text-3xl font-semibold text-teal-600 leading-none">15</p>
        <p class="text-xs text-slate-400 mt-2">Mengisi formulir PMB</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Registrasi Ulang</p>
        <p class="text-3xl font-semibold text-amber-600 leading-none">8</p>
        <p class="text-xs text-slate-400 mt-2">Menjadi mahasiswa aktif</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Total Bonus</p>
        <p class="text-xl font-semibold text-violet-600 leading-none mt-1">Rp 2.000.000</p>
        <p class="text-xs text-slate-400 mt-2">Bonus berjalan</p>
    </div>
</div>

<!-- Progress + Bonus -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    <!-- Progress funnel -->
    <div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-5">
            <p class="text-sm font-medium text-slate-800">Progress PMB</p>
            <span class="text-xs text-slate-400">Konversi prospek → aktif</span>
        </div>
        <div class="space-y-5">
            <!-- Prospek -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-xs text-slate-500">Prospek</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400">100%</span>
                        <span class="text-xs font-medium text-slate-800">24</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-blue-400 h-2 rounded-full" style="width:100%"></div>
                </div>
            </div>
            <!-- Sudah Daftar -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-xs text-slate-500">Sudah Daftar</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400">62%</span>
                        <span class="text-xs font-medium text-teal-600">15</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-teal-500 h-2 rounded-full" style="width:62%"></div>
                </div>
            </div>
            <!-- Registrasi Ulang -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-xs text-slate-500">Registrasi Ulang</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400">33%</span>
                        <span class="text-xs font-medium text-amber-600">8</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width:33%"></div>
                </div>
            </div>
        </div>

        <!-- Conversion note -->
        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-6">
            <div class="text-center">
                <p class="text-xs text-slate-400">Tingkat daftar</p>
                <p class="text-sm font-semibold text-slate-800 mt-0.5">62,5%</p>
            </div>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="text-center">
                <p class="text-xs text-slate-400">Tingkat registrasi</p>
                <p class="text-sm font-semibold text-slate-800 mt-0.5">53,3%</p>
            </div>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="text-center">
                <p class="text-xs text-slate-400">Konversi total</p>
                <p class="text-sm font-semibold text-teal-600 mt-0.5">33,3%</p>
            </div>
        </div>
    </div>

    <!-- Bonus card -->
    <div class="bg-white rounded-xl border border-slate-100 p-5 flex flex-col justify-between">
        <p class="text-sm font-medium text-slate-800 mb-4">Rincian Bonus</p>

        <div class="bg-slate-50 rounded-lg px-4 py-4 mb-4">
            <p class="text-xs text-slate-400 mb-1">Total bonus berjalan</p>
            <p class="text-2xl font-semibold text-violet-600">Rp 2.000.000</p>
            <p class="text-xs text-slate-400 mt-1.5">8 registrasi × Rp 250.000</p>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Bonus per registrasi</span>
                <span class="font-medium text-slate-800">Rp 250.000</span>
            </div>
            <hr class="border-slate-100">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Registrasi ulang</span>
                <span class="font-medium text-amber-600">8 mahasiswa</span>
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
        <div class="flex items-center gap-2">
            <div class="relative">
                <i class="ti ti-search text-slate-400 text-sm absolute left-2.5 top-1/2 -translate-y-1/2" aria-hidden="true"></i>
                <input type="text" placeholder="Cari nama..." class="text-xs pl-7 pr-3 py-1.5 border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-400 w-40">
            </div>
            <select class="text-xs text-slate-600 border border-slate-200 rounded-md px-2.5 py-1.5 bg-white focus:outline-none">
                <option value="">Semua status</option>
                <option>Prospek</option>
                <option>Sudah Daftar</option>
                <option>Registrasi Ulang</option>
            </select>
        </div>
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
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">Andi Saputra</td>
                    <td class="px-5 py-3.5 text-slate-600">Informatika</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">12 Jan 2026</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Prospek</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">–</td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">Rina Putri</td>
                    <td class="px-5 py-3.5 text-slate-600">Sistem Informasi</td>
                    <td class="px-5 py-3.5 text-slate-600">RPL</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">18 Jan 2026</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-700">Registrasi Ulang</span>
                    </td>
                    <td class="px-5 py-3.5 text-xs font-medium text-teal-600">Rp 250.000</td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">Budi Santoso</td>
                    <td class="px-5 py-3.5 text-slate-600">Manajemen</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">20 Jan 2026</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">Sudah Daftar</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">–</td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">Dewi Lestari</td>
                    <td class="px-5 py-3.5 text-slate-600">Akuntansi</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">25 Jan 2026</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Prospek</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">–</td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">Yoga Pratama</td>
                    <td class="px-5 py-3.5 text-slate-600">Teknik Industri</td>
                    <td class="px-5 py-3.5 text-slate-600">RPL</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">02 Feb 2026</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-700">Registrasi Ulang</span>
                    </td>
                    <td class="px-5 py-3.5 text-xs font-medium text-teal-600">Rp 250.000</td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 font-medium text-slate-800">Sari Wulandari</td>
                    <td class="px-5 py-3.5 text-slate-600">Psikologi</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">10 Feb 2026</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">Sudah Daftar</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">–</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-400">Menampilkan 6 dari 24 camaba</p>
        <div class="flex items-center gap-1">
            <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">
                <i class="ti ti-chevron-left text-sm" aria-hidden="true"></i>
            </button>
            <button class="text-xs bg-blue-600 text-white px-2.5 py-1 rounded">1</button>
            <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">2</button>
            <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">3</button>
            <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">
                <i class="ti ti-chevron-right text-sm" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

@endsection

