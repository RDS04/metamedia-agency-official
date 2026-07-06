@extends('auth.layout.app')

@section('title', 'Daftar Mahasiswa Agent')

@section('content')
<div class="min-h-screen bg-slate-50 p-6">
    <div class="mx-auto max-w-7xl space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-800">Daftar Mahasiswa Agent</h1>
                    <p class="text-sm text-slate-500">Agent: <span class="font-semibold text-slate-700">{{ $agent->name }}</span></p>
                </div>
                <a href="{{ route('listAgent') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                    ← Kembali ke List Agent
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <p class="text-sm font-semibold text-slate-800">Mahasiswa yang terdaftar melalui agent ini</p>
                <p class="text-xs text-slate-500">Total: {{ $mahasiswa->count() }} mahasiswa</p>
            </div>

            @if($mahasiswa->isEmpty())
                <div class="px-5 py-8 text-center text-sm text-slate-500">
                    Belum ada mahasiswa yang terdaftar melalui agent ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Nama Mahasiswa</th>
                                <th class="px-5 py-3">No HP</th>
                                <th class="px-5 py-3">Program Studi</th>
                                <th class="px-5 py-3">Periode</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($mahasiswa as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-3 font-medium text-slate-700">{{ $item->nama_lengkap ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $item->nomor_hp ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $item->program_studi ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $item->periode ?? '-' }}</td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                            {{ $item->status ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
