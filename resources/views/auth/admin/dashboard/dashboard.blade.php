
@extends('auth.layout.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')

@section('content')

@php
    $statusClasses = [
        'Prospek' => 'bg-amber-50 text-amber-700 border border-amber-200/50',
        'Dihubungi' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/50',
        'Sudah Daftar' => 'bg-blue-50 text-blue-700 border border-blue-200/50',
        'Registrasi' => 'bg-violet-50 text-violet-700 border border-violet-200/50',
        'Registrasi Ulang' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/50',
        'Batal' => 'bg-red-50 text-red-700 border border-red-200/50',
    ];
@endphp

<!-- ── Metric cards ── -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
    <!-- Prospek -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4 transition hover:shadow-sm">
        <p class="text-xs text-slate-400 font-medium mb-1">Prospek Camaba</p>
        <p class="text-3xl font-semibold text-slate-800 leading-none">{{ $totalProspek }}</p>
        <p class="text-xs text-slate-400 mt-2">Total calon mahasiswa</p>
    </div>
    <!-- Daftar -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4 transition hover:shadow-sm">
        <p class="text-xs text-slate-400 font-medium mb-1">Sudah Daftar</p>
        <p class="text-3xl font-semibold text-teal-600 leading-none">{{ $totalSudahDaftar }}</p>
        <p class="text-xs text-slate-400 mt-2">Mengisi formulir PMB</p>
    </div>
    <!-- Registrasi -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4 transition hover:shadow-sm">
        <p class="text-xs text-slate-400 font-medium mb-1">Registrasi Ulang</p>
        <p class="text-3xl font-semibold text-amber-600 leading-none">{{ $totalRegistrasiUlang }}</p>
        <p class="text-xs text-slate-400 mt-2">Mahasiswa aktif</p>
    </div>
    <!-- Bonus -->
    <div class="bg-white rounded-xl border border-slate-100 px-5 py-4 transition hover:shadow-sm">
        <p class="text-xs text-slate-400 font-medium mb-1">Total Bonus Berjalan</p>
        <p class="text-xl font-bold text-violet-600 leading-none mt-1">Rp {{ number_format($totalBonusBerjalan, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-2">Periode aktif saat ini</p>
    </div>
</div>

<!-- ── Chart + Referral ── -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mt-4">

    <!-- Chart -->
    <div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-slate-800">Progress Camaba</p>
            <span class="text-xs text-slate-400">
                @if(count($chartLabels) > 0)
                    {{ reset($chartLabels) }} – {{ end($chartLabels) }}
                @endif
            </span>
        </div>
        <div class="h-48">
            <canvas id="agentChart"></canvas>
        </div>
    </div>

    <!-- Agent summary card -->
    <div class="bg-white rounded-xl border border-slate-100 p-5 flex flex-col justify-between">
        <div>
            <p class="text-sm font-medium text-slate-800 mb-3">Statistik & Top Agent</p>
            
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-slate-50 border border-slate-100/50 rounded-lg p-3 text-center transition hover:bg-slate-100/50">
                    <p class="text-[10px] text-slate-400 font-semibold uppercase">Total Agent</p>
                    <p class="text-2xl font-bold text-slate-800 mt-0.5">{{ $totalAgent }}</p>
                </div>
                <div class="bg-slate-50 border border-slate-100/50 rounded-lg p-3 text-center transition hover:bg-slate-100/50">
                    <p class="text-[10px] text-slate-400 font-semibold uppercase">Agent Aktif</p>
                    <p class="text-2xl font-bold text-[#018FD7] mt-0.5">{{ $activeAgent }}</p>
                </div>
            </div>

            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Top 3 Agent (Registrasi Ulang)</p>
            <div class="space-y-2">
                @forelse($topAgents as $index => $agent)
                    <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 last:border-0">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-slate-100 border border-slate-200/50 flex items-center justify-center font-bold text-[10px] text-slate-500">
                                {{ $index + 1 }}
                            </span>
                            <span class="font-medium text-slate-700 truncate max-w-[120px]">{{ $agent->name }}</span>
                        </div>
                        <span class="text-teal-600 font-semibold bg-teal-50 px-2 py-0.5 rounded-full border border-teal-100">{{ $agent->camabas_count }} Mhs</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data registrasi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ── Table ── -->
<div class="bg-white rounded-xl border border-slate-100 overflow-hidden mt-4">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <p class="text-sm font-medium text-slate-800">Camaba Terbaru</p>
        <a href="{{ route('mahasiswa.create') }}"
            class="flex items-center gap-1.5 text-xs text-slate-600 border border-slate-200 bg-white px-3 py-1.5 rounded-md hover:bg-slate-50 transition-colors">
            <i class="ti ti-plus text-sm" aria-hidden="true"></i>
            Input Mahasiswa
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">Nama Camaba</th>
                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">Program Studi</th>
                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">Sistem Kuliah</th>
                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">Referral Agent</th>
                    <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">Status</th>
                    <th class="text-center text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($camabaTerbaru as $c)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-slate-800">{{ $c->nama_lengkap }}</p>
                            <p class="text-[10px] text-slate-400">NIK/NIM: {{ $c->nik }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $c->program_studi }}</td>
                        <td class="px-5 py-3.5 text-slate-600">
                            <p>{{ $c->sistem_kuliah }}</p>
                            <p class="text-[10px] text-slate-400">{{ $c->periode }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($c->agent)
                                <p class="text-slate-800 font-medium">{{ $c->agent->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ \App\Helpers\StatusHelper::formatStatus($c->agent->status) }}</p>
                            @else
                                <span class="text-xs text-slate-400 italic">Tanpa Agent</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center text-[10px] font-medium px-2 py-0.5 rounded-full {{ $statusClasses[$c->status] ?? $statusClasses['Prospek'] }}">
                                {{ $c->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <a href="{{ route('dataCamaba') }}?search={{ urlencode($c->nama_lengkap) }}"
                                class="inline-flex items-center gap-1 text-xs text-[#018FD7] hover:underline font-medium">
                                <i class="ti ti-edit text-xs"></i> Kelola
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-400 italic text-xs">
                            Belum ada data calon mahasiswa terbaru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table footer -->
    <div class="px-5 py-3.5 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-400">Menampilkan {{ min($camabaTerbaru->count(), 5) }} dari {{ $totalCamaba }} camaba</p>
        <a href="{{ route('dataCamaba') }}" class="text-xs text-[#018FD7] hover:underline font-semibold flex items-center gap-1">
            Lihat semua camaba
            <i class="ti ti-arrow-right text-xs"></i>
        </a>
    </div>
</div>

<script>
    // ── Chart ──
    const ctx = document.getElementById('agentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Camaba Terdaftar',
                data: {!! json_encode($chartData) !!},
                borderColor: '#378add',
                backgroundColor: 'rgba(55,138,221,0.06)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#378add',
                pointBorderColor: '#fff',
                pointBorderWidth: 1.5,
                borderWidth: 2
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
                    grid: { color: 'rgba(0,0,0,0.02)' },
                    ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8' },
                    border: { display: false }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8', precision: 0 },
                    border: { display: false },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
