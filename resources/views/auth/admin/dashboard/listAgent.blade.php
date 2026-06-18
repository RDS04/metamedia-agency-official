@extends('auth.layout.app')

@section('title', 'Data Agent')

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
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<div class="flex flex-col min-h-screen">

    <!-- ── Topbar ── -->
    <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0  top-0 z-10">
        <div>
            <h1 class="text-sm font-semibold text-slate-800">Data Agent</h1>
            <p class="text-xs text-slate-400">Kelola seluruh agent PMB</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-500 border border-slate-200 rounded-md px-3 py-1.5 bg-white">PMB 2026 Ganjil</span>
            <!-- Tambah Agent button -->
            <a href="#"
               class="flex items-center gap-1.5 text-xs bg-brand-600 text-white px-3 py-1.5 rounded-md hover:bg-brand-800 transition-colors">
                <i class="ti ti-plus text-sm" aria-hidden="true"></i>
                Tambah Agent
            </a>
            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">
                <i class="ti ti-bell text-base" aria-hidden="true"></i>
            </button>
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

        <!-- ── Filter bar ── -->
        <div class="bg-white rounded-xl border border-slate-100 px-5 py-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Search -->
                <div class="relative">
                    <i class="ti ti-search text-slate-400 text-sm absolute left-2.5 top-1/2 -translate-y-1/2" aria-hidden="true"></i>
                    <input
                        type="text"
                        placeholder="Cari agent..."
                        class="w-full text-xs pl-7 pr-3 py-2 border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-brand-400 placeholder-slate-400">
                </div>

                <!-- Role -->
                <select class="text-xs text-slate-600 border border-slate-200 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-brand-400">
                    <option value="">Semua Role</option>
                    <option>Mahasiswa</option>
                    <option>Alumni</option>
                    <option>Orang Tua</option>
                    <option>Dosen</option>
                    <option>Karyawan</option>
                    <option>Mitra</option>
                </select>

                <!-- Status -->
                <select class="text-xs text-slate-600 border border-slate-200 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-brand-400">
                    <option value="">Semua Status</option>
                    <option>Aktif</option>
                    <option>Non Aktif</option>
                </select>

                <!-- Filter button -->
                <button class="flex items-center justify-center gap-1.5 text-xs bg-slate-800 text-white px-3 py-2 rounded-md hover:bg-slate-700 transition-colors">
                    <i class="ti ti-filter text-sm" aria-hidden="true"></i>
                    Filter
                </button>
            </div>
        </div>

        <!-- ── Table ── -->
        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <p class="text-sm font-medium text-slate-800">List Agent</p>
                <p class="text-xs text-slate-400">Menampilkan 5 dari 24 agent</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Nama</th>
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Agent Role</th>
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">No HP</th>
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Kode Referral</th>
                            <th class="text-left text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Status</th>
                            <th class="text-center text-xs font-medium text-slate-400 uppercase tracking-wide px-5 py-3">Aktif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                    @foreach ($agents as $agent)
                        <!-- Row 1 – Aktif -->
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="font-medium text-slate-800">{{ $agent->name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $agent->created_at?->format('d M Y') ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-brand-50 text-brand-600">{{ ucwords(str_replace('_', ' ', $agent->status)) }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $agent->phone }}</td>
                            <td class="px-5 py-3.5">
                                <span class="font-mono text-xs text-slate-700 bg-slate-100 px-2 py-1 rounded">{{ $agent->kode_referral }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span data-status-badge class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full transition-colors duration-300 {{ $agent->is_active ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $agent->is_active ? 'Aktif' : 'Non Aktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <form action="{{ route('agent.toggle', $agent->id) }}" method="POST" class="js-toggle-agent-form">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        data-active="{{ $agent->is_active ? 'true' : 'false' }}"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 ease-out {{ $agent->is_active ? 'bg-teal-500' : 'bg-slate-300' }} focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-2 active:scale-95 disabled:cursor-wait disabled:opacity-80"
                                        title="{{ $agent->is_active ? 'Klik untuk non-aktifkan' : 'Klik untuk aktifkan' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-300 ease-out {{ $agent->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Table footer / pagination -->
            <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">Menampilkan 5 dari 24 agent</p>
                <div class="flex items-center gap-1">
                    <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">
                        <i class="ti ti-chevron-left text-sm" aria-hidden="true"></i>
                    </button>
                    <button class="text-xs bg-brand-600 text-white px-2.5 py-1 rounded">1</button>
                    <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">2</button>
                    <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">3</button>
                    <button class="text-xs text-slate-500 border border-slate-200 px-2.5 py-1 rounded hover:bg-slate-50 transition-colors">
                        <i class="ti ti-chevron-right text-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
// Toggle aktif/non-aktif (preview — di Laravel gunakan form POST)
function toggleStatus(btn) {
    const isActive = btn.dataset.active === 'true';
    const dot = btn.querySelector('span');
    const statusBadge = btn.closest('tr').querySelector('td:nth-child(5) span');

    if (isActive) {
        // → Non Aktif
        btn.dataset.active = 'false';
        btn.classList.remove('bg-teal-500');
        btn.classList.add('bg-slate-300');
        dot.classList.remove('translate-x-6');
        dot.classList.add('translate-x-1');
        statusBadge.className = 'inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-slate-100 text-slate-500';
        statusBadge.textContent = 'Non Aktif';
    } else {
        // → Aktif
        btn.dataset.active = 'true';
        btn.classList.remove('bg-slate-300');
        btn.classList.add('bg-teal-500');
        dot.classList.remove('translate-x-1');
        dot.classList.add('translate-x-6');
        statusBadge.className = 'inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-700';
        statusBadge.textContent = 'Aktif';
    }
}
</script>

<script>
document.querySelectorAll('.js-toggle-agent-form').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const button = form.querySelector('button[data-active]');

        if (!button || button.dataset.submitting === 'true') {
            return;
        }

        event.preventDefault();

        const isActive = button.dataset.active === 'true';
        const nextActive = !isActive;
        const knob = button.querySelector('span');
        const statusBadge = form.closest('tr').querySelector('[data-status-badge]');

        button.dataset.active = nextActive ? 'true' : 'false';
        button.dataset.submitting = 'true';
        button.disabled = true;

        button.classList.toggle('bg-teal-500', nextActive);
        button.classList.toggle('bg-slate-300', !nextActive);
        knob.classList.toggle('translate-x-6', nextActive);
        knob.classList.toggle('translate-x-1', !nextActive);

        statusBadge.classList.toggle('bg-teal-50', nextActive);
        statusBadge.classList.toggle('text-teal-700', nextActive);
        statusBadge.classList.toggle('bg-slate-100', !nextActive);
        statusBadge.classList.toggle('text-slate-500', !nextActive);
        statusBadge.textContent = nextActive ? 'Aktif' : 'Non Aktif';

        setTimeout(() => form.submit(), 260);
    });
});
</script>

</body>

@endsection
