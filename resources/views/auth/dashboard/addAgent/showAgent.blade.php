@extends('auth.layout.app')

@section('title', 'Daftar Agent')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center">

        <div>
            <h1 class="text-3xl font-bold text-black">
                Daftar Agent
            </h1>

            <p class="text-gray-400 mt-1">
                Kelola data agent di sistem
            </p>
        </div>

        <a href="{{ route('agen.Create') }}"
            class="bg-[#018FD7] hover:bg-[#0177BB] text-white px-4 py-2 rounded-lg transition font-medium">
            + Tambah Agent
        </a>

    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden">

        <div class="border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-[#018FD7] to-[#0177BB]">

            <h2 class="text-white text-lg font-semibold">
                Data Agent
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NIK</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No. HP</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Program Studi</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @if($agents->count() > 0)

                        @foreach($agents as $key => $agent)

                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $key + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $agent->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $agent->nik }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $agent->nomor_hp }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                        {{ $agent->jenis_kelamin }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $agent->program_studi }}</td>
                                <td class="px-6 py-4 text-sm space-x-2 flex">

                                    <a href="{{ route('agen.Edit', $agent->id) }}"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('agen.Destroy', $agent->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus agent ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>

                        @endforeach

                    @else

                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data agent. <a href="{{ route('agen.Create') }}" class="text-[#018FD7] font-semibold hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection