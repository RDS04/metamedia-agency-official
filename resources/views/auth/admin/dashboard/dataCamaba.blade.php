@extends('auth.layout.app')

@section('title', 'Data Camaba')

@section('content')

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-black">Data Calon Mahasiswa</h1>
            <p class="text-gray-400 mt-1">Pantau camaba yang didaftarkan oleh agent.</p>
        </div>

        <form method="GET" action="{{ route('dataCamaba') }}" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, NIK, agent..."
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

            <select name="agent_id"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                <option value="">Semua agent</option>
                @foreach($agentOptions as $agent)
                    <option value="{{ $agent->id }}" {{ (string) request('agent_id') === (string) $agent->id ? 'selected' : '' }}>
                    {{ \App\Helpers\StatusHelper::formatStatus($agent->status) }}
                    </option>
                @endforeach
            </select>

            <select name="status"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                <option value="">Semua status</option>
                @foreach($statusOptions as $status => $class)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="rounded-lg bg-[#018FD7] px-4 py-2 text-sm font-medium text-white hover:bg-[#0177BB] transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'agent_id', 'status']))
                <a href="{{ route('dataCamaba') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-[#018FD7] to-[#0177BB]">
            <h2 class="text-white text-lg font-semibold">List Camaba</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Camaba</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Agent</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kontak</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Program</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Update Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($camabas as $camaba)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $camabas->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-gray-800">{{ $camaba->nama_lengkap }}</p>
                                <p class="text-xs text-gray-400">NIK: {{ $camaba->nik }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $camaba->agent->name ?? 'Belum terhubung' }}</p>
                                @if($camaba->agent)
                                    <p class="text-xs text-gray-400">{{ \App\Helpers\StatusHelper::formatStatus($camaba->agent->status) }}</p>
                                @endif
                                <p class="text-xs text-gray-400">{{ $camaba->created_at?->format('d M Y') ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $camaba->nomor_hp }}</td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $camaba->program_studi }}</p>
                                <p class="text-xs text-gray-400">{{ $camaba->sistem_kuliah }} - {{ $camaba->periode }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full {{ $statusOptions[$camaba->status] ?? $statusOptions['Prospek'] }}">
                                    {{ $camaba->status ?? 'Prospek' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('dataCamaba.status', $camaba->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                        class="rounded-lg border border-gray-300 px-3 py-2 text-xs text-gray-700 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                                        @foreach($statusOptions as $status => $class)
                                            <option value="{{ $status }}" {{ $camaba->status === $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="rounded-lg bg-gray-800 px-3 py-2 text-xs font-medium text-white hover:bg-gray-700 transition">
                                        Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data camaba.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <p class="text-xs text-gray-400">
                Menampilkan {{ $camabas->firstItem() ?? 0 }} sampai {{ $camabas->lastItem() ?? 0 }} dari {{ $camabas->total() }} camaba
            </p>
            <div>
                {{ $camabas->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
