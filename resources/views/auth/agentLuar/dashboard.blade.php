@extends('auth.layout.app')

@section('title', 'Dashboard — Agent Umum')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Welcome banner --}}
    <div class="bg-gradient-to-r from-[#013A7A] to-[#018FD7] rounded-2xl p-5 mb-4 text-white flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="text-blue-200 text-xs font-medium mb-0.5">Selamat datang kembali 👋</p>
            <h2 class="text-xl font-bold">{{ $agentLuar->name }}</h2>
            <p class="text-blue-200 text-xs mt-1 capitalize">
                Agent Umum · {{ ucwords(str_replace('_', ' ', $agentLuar->status)) }}
                · Rekruter: <span class="text-white font-semibold">{{ $agentLuar->agentInternal->name ?? 'N/A' }}</span>
            </p>
        </div>
     
    </div>

    {{-- Alert messages --}}
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

    <!-- ── Metric cards ── -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
        <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
            <p class="text-xs text-slate-400 font-medium mb-2">Prospek Camaba</p>
            <p class="text-3xl font-semibold text-slate-800 leading-none">{{ $prospek }}</p>
            <p class="text-xs text-slate-400 mt-2">Total calon mahasiswa</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
            <p class="text-xs text-slate-400 font-medium mb-2">Sudah Daftar</p>
            <p class="text-3xl font-semibold text-blue-600 leading-none">{{ $sudahDaftar }}</p>
            <p class="text-xs text-slate-400 mt-2">Mengisi formulir PMB</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
            <p class="text-xs text-slate-400 font-medium mb-2">Registrasi Ulang</p>
            <p class="text-3xl font-semibold text-emerald-600 leading-none">{{ $registrasiUlang }}</p>
            <p class="text-xs text-slate-400 mt-2">Mahasiswa aktif</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
            <p class="text-xs text-slate-400 font-medium mb-2">Estimasi Bonus</p>
            <p class="text-xl font-semibold text-violet-600 leading-none mt-1">Rp {{ number_format($totalBonus, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-2">Periode aktif</p>
        </div>
    </div>

    <!-- ── Chart + Status Monitor ── -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-4">

        <!-- Chart -->
        <div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-slate-800">Progress Camaba</p>
                <span class="text-xs text-slate-400">{{ $chartLabels[0] ?? '-' }} - {{ $chartLabels[count($chartLabels)-1] ?? '-' }}</span>
            </div>
            <div class="h-44">
                <canvas id="agentChart"></canvas>
            </div>
        </div>

        <!-- Status Monitor -->
        <div class="bg-white rounded-xl border border-slate-100 p-5">
            <p class="text-sm font-medium text-slate-800 mb-4">Status Camaba</p>
            <div class="space-y-3">
                @foreach($statusMonitor as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg {{ $item['bg'] }} flex items-center justify-center flex-shrink-0">
                            <i class="ti {{ $item['icon'] }} text-xs {{ $item['text'] }}" aria-hidden="true"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs text-slate-600">{{ $item['label'] }}</span>
                                <span class="text-xs font-semibold {{ $item['text'] }}">{{ $item['count'] }}</span>
                            </div>
                            @if($totalCamaba > 0)
                                <div class="w-full bg-slate-100 rounded-full h-1.5">
                                    <div class="{{ $item['bar'] }} h-1.5 rounded-full transition-all" style="width: {{ round(($item['count']/$totalCamaba)*100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ── Table camaba terbaru ── -->
    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <p class="text-sm font-medium text-slate-800">Camaba Terbaru</p>
            <a href="{{ route('agent-luar.camaba.create') }}"
                class="flex items-center gap-1.5 text-xs text-slate-500 border border-slate-200 px-3 py-1.5 rounded-md hover:bg-slate-50 transition-colors">
                <i class="ti ti-plus text-sm" aria-hidden="true"></i>
                Tambah Camaba
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Nama</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Program Studi</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Sistem Kuliah</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Status</th>
                        <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($camabaTerbaru as $maba)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3.5 text-slate-800 font-medium">{{ $maba->nama_lengkap }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $maba->program_studi }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $maba->sistem_kuliah }}</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full {{ $statusOptions[$maba->status] ?? $statusOptions['Prospek'] }}">
                                    {{ $maba->status ?? 'Prospek' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('agent-luar.camaba.show', $maba->id) }}"
                                    class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1">
                                    <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-400">
                                Belum ada data camaba. <a href="{{ route('agent-luar.camaba.create') }}" class="text-[#018FD7] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-400">Menampilkan {{ $camabaTerbaru->count() }} dari {{ $totalCamaba }} camaba</p>
            <a href="{{ route('agent-luar.camaba.index') }}"
                class="text-xs text-blue-600 border border-blue-100 bg-blue-50 px-3 py-1.5 rounded-md hover:bg-blue-100 transition-colors">
                Lihat semua
            </a>
        </div>
    </div>

    <script>
        // ── Chart ──
        const ctx = document.getElementById('agentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Camaba',
                    data: @json($chartData),
                    borderColor: '#018FD7',
                    backgroundColor: 'rgba(1,143,215,0.07)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#018FD7',
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
                        bodyColor: '#018FD7',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: { label: ctx => ` ${ctx.parsed.y} camaba` }
                    }
                },
                scales: {
                    x: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8' }, border: { display: false } },
                    y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8', stepSize: 1 }, border: { display: false }, beginAtZero: true }
                }
            }
        });

        // ── Copy kode referral ──
        function copyKode() {
            const kode = document.getElementById('kodeReferral').textContent.trim();
            navigator.clipboard.writeText(kode).then(() => {
                const msg = document.getElementById('copyMsg');
                msg.classList.remove('hidden');
                setTimeout(() => msg.classList.add('hidden'), 2000);
            });
        }
    </script>

@endsection