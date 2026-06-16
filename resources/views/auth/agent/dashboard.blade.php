
@extends('auth.layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<!-- ── Metric cards ── -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
    <!-- Prospek -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Prospek Camaba</p>
        <p class="text-3xl font-semibold text-slate-800 leading-none">24</p>
        <p class="text-xs text-slate-400 mt-2">Total calon mahasiswa</p>
    </div>
    <!-- Daftar -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Sudah Daftar</p>
        <p class="text-3xl font-semibold text-teal-600 leading-none">15</p>
        <p class="text-xs text-slate-400 mt-2">Mengisi formulir PMB</p>
    </div>
    <!-- Registrasi -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Registrasi Ulang</p>
        <p class="text-3xl font-semibold text-amber-600 leading-none">8</p>
        <p class="text-xs text-slate-400 mt-2">Mahasiswa aktif</p>
    </div>
    <!-- Bonus -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
        <p class="text-xs text-slate-400 font-medium mb-2">Bonus Berjalan</p>
        <p class="text-xl font-semibold text-violet-600 leading-none mt-1">Rp 2.000.000</p>
        <p class="text-xs text-slate-400 mt-2">Periode aktif</p>
    </div>
</div>

<!-- ── Chart + Referral ── -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    <!-- Chart -->
    <div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-slate-800">Progress Camaba</p>
            <span class="text-xs text-slate-400">Januari – Juni 2026</span>
        </div>
        <div class="h-44">
            <canvas id="agentChart"></canvas>
        </div>
    </div>

    <!-- Referral card -->
    <div class="bg-white rounded-xl border border-slate-100 p-5">
        <p class="text-sm font-medium text-slate-800 mb-4">Kode Referral</p>

        <div class="bg-slate-50 rounded-lg px-4 py-3 mb-4">
            <p class="text-xs text-slate-400 mb-1">Kode aktif Anda</p>
            <p class="text-lg font-semibold text-slate-800 tracking-widest">AGT2026001</p>
            <button id="copyBtn" onclick="copyCode()"
                class="mt-3 flex items-center gap-1.5 text-xs text-slate-500 border border-slate-200 bg-white px-3 py-1.5 rounded-md hover:bg-slate-50 transition-colors">
                <i class="ti ti-copy text-sm" aria-hidden="true"></i>
                Salin kode
            </button>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Total referral</span>
                <span class="font-medium text-slate-800">24</span>
            </div>
            <hr class="border-slate-100">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Registrasi ulang</span>
                <span class="font-medium text-teal-600">8</span>
            </div>
            <hr class="border-slate-100">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400">Total bonus</span>
                <span class="font-medium text-violet-600">Rp 2.000.000</span>
            </div>
        </div>
    </div>
</div>

<!-- ── Table ── -->
<div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <p class="text-sm font-medium text-slate-800">Camaba terbaru</p>
        <button
            class="flex items-center gap-1.5 text-xs text-slate-500 border border-slate-200 px-3 py-1.5 rounded-md hover:bg-slate-50 transition-colors">
            <i class="ti ti-plus text-sm" aria-hidden="true"></i>
            Tambah camaba
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th
                        class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">
                        Nama</th>
                    <th
                        class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">
                        Program Studi</th>
                    <th
                        class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">
                        Sistem Kuliah</th>
                    <th
                        class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">
                        Status</th>
                    <th
                        class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 text-slate-800 font-medium">Andi Saputra</td>
                    <td class="px-5 py-3.5 text-slate-600">Informatika</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5">
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Prospek</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <button
                            class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1">
                            <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 text-slate-800 font-medium">Rina Putri</td>
                    <td class="px-5 py-3.5 text-slate-600">Sistem Informasi</td>
                    <td class="px-5 py-3.5 text-slate-600">RPL</td>
                    <td class="px-5 py-3.5">
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-700">Registrasi
                            ulang</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <button
                            class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1">
                            <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 text-slate-800 font-medium">Budi Santoso</td>
                    <td class="px-5 py-3.5 text-slate-600">Manajemen</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5">
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-brand-50 text-brand-600">Sudah
                            daftar</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <button
                            class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1">
                            <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 text-slate-800 font-medium">Dewi Lestari</td>
                    <td class="px-5 py-3.5 text-slate-600">Akuntansi</td>
                    <td class="px-5 py-3.5 text-slate-600">Reguler</td>
                    <td class="px-5 py-3.5">
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Prospek</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <button
                            class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1">
                            <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 text-slate-800 font-medium">Yoga Pratama</td>
                    <td class="px-5 py-3.5 text-slate-600">Teknik Industri</td>
                    <td class="px-5 py-3.5 text-slate-600">RPL</td>
                    <td class="px-5 py-3.5">
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-700">Registrasi
                            ulang</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <button
                            class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1">
                            <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table footer -->
    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-400">Menampilkan 5 dari 24 camaba</p>
        <div class="flex items-center gap-1">
            <button
                class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">
                <i class="ti ti-chevron-left text-sm" aria-hidden="true"></i>
            </button>
            <button class="text-xs bg-brand-600 text-white px-2.5 py-1 rounded">1</button>
            <button
                class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">2</button>
            <button
                class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">3</button>
            <button
                class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">
                <i class="ti ti-chevron-right text-sm" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

    <script>
        // ── Chart ──
        const ctx = document.getElementById('agentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Camaba',
                    data: [2, 5, 8, 12, 18, 24],
                    borderColor: '#378add',
                    backgroundColor: 'rgba(55,138,221,0.06)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#378add',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1.5,
                    borderWidth: 1.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#94a3b8',
                        bodyColor: '#378add',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        titleFont: { size: 11, family: 'Inter' },
                        bodyFont: { size: 13, weight: '500', family: 'Inter' },
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} camaba`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8' },
                        border: { display: false }
                    },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8', stepSize: 6 },
                        border: { display: false },
                        beginAtZero: true
                    }
                }
            }
        });

        // ── Copy referral code ──
        function copyCode() {
            navigator.clipboard.writeText('AGT2026001').catch(() => { });
            const btn = document.getElementById('copyBtn');
            btn.innerHTML = '<i class="ti ti-check text-sm"></i> Tersalin';
            btn.classList.add('text-teal-600', 'border-teal-200');
            setTimeout(() => {
                btn.innerHTML = '<i class="ti ti-copy text-sm"></i> Salin kode';
                btn.classList.remove('text-teal-600', 'border-teal-200');
            }, 2000);
        }
    </script>

@endsection
