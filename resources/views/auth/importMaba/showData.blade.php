@extends('auth.layout.app')

@section('title', 'Data Mahasiswa')

@section('content')

    <div class="space-y-5">

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-red-800 text-sm">Terjadi Kesalahan</h3>
                        <ul class="mt-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-green-800 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Data Mahasiswa
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    Kelola data mahasiswa PMB
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('mahasiswa.create') }}"
                    class="bg-gray-800 hover:bg-gray-900 text-white text-sm px-4 py-2.5 rounded-lg transition-colors">
                    + Tambah Mahasiswa
                </a>
                <a href="{{ route('mahasiswa.create') }}"
                    class="bg-gray-700 hover:bg-gray-800 text-white text-sm px-4 py-2.5 rounded-lg transition-colors">
                    Import Excel
                </a>
                <a href="{{ route('mahasiswa.export') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2.5 rounded-lg transition-colors">
                    Export Excel
                </a>
            </div>

        </div>

        <!-- Card Statistik - Compact -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-2">
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">Total</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $totalMahasiswa }}</h2>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">Sistem Informasi</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $sistemInformasi }}</h2>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">Informatika</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $informatika }}</h2>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">Bisnis Digital</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $bisnisDigital }}</h2>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">DKV</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $dkv }}</h2>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">PTI</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $pti }}</h2>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-3">
                <p class="text-xs text-gray-500">Manajemen Ritel</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $manajemenRitel }}</h2>
            </div>
        </div>

        <!-- Filter - Compact -->
        <form action="{{ route('mahasiswa.index') }}" method="GET" class="bg-white rounded-lg border border-gray-200 p-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari mahasiswa..."
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">

                <select name="program_studi" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                    <option value="">Semua Prodi</option>
                    @foreach(\App\Models\Mahasiswa::PROGRAM_STUDI as $prodi)
                        <option value="{{ $prodi }}" {{ request('program_studi') === $prodi ? 'selected' : '' }}>
                            {{ $prodi }}
                        </option>
                    @endforeach
                </select>

                <select name="sistem_kuliah" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                    <option value="">Semua Sistem Kuliah</option>
                    <option value="Reguler" {{ request('sistem_kuliah') === 'Reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="Mandiri" {{ request('sistem_kuliah') === 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                    <option value="Mandiri_transfer" {{ request('sistem_kuliah') === 'Mandiri_transfer' ? 'selected' : '' }}>Mandiri Transfer</option>
                    <option value="RPL" {{ request('sistem_kuliah') === 'RPL' ? 'selected' : '' }}>RPL</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white text-sm rounded-lg px-3 py-2 transition-colors">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'program_studi', 'sistem_kuliah']))
                        <a href="{{ route('mahasiswa.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>

            </div>

        </form>

        <!-- Tabel - Compact & Clean -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">

            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h2 class="font-medium text-sm text-gray-700">
                    List Mahasiswa
                    <span class="text-gray-400 font-normal ml-2">({{ $mahasiswas->total() }})</span>
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Pendaftaran</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK / NIM</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sistem Kuliah</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-2.5 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($mahasiswas as $item)

                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">

                                <td class="px-4 py-3 text-gray-600 text-xs">
                                    {{ ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-800 text-xs">
                                    {{ $item->no_pendaftaran }}
                                </td>

                                <td class="px-4 py-3 text-gray-700 text-xs">
                                    {{ $item->nama_lengkap }}
                                </td>

                                <td class="px-4 py-3 text-gray-600 text-xs">
                                    {{ $item->nik }}
                                </td>

                                <td class="px-4 py-3 text-gray-700 text-xs">
                                    {{ $item->program_studi }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2.5 py-0.5 rounded">
                                        {{ $item->sistem_kuliah }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="inline-block bg-green-100 text-green-700 text-xs px-2.5 py-0.5 rounded">
                                        Aktif
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="#" class="text-gray-500 hover:text-gray-700 px-2.5 py-1.5 rounded-lg text-xs transition-colors">
                                            Detail
                                        </a>
                                        <a href="{{ route('mahasiswa.edit', $item->id) }}"
                                            class="text-gray-500 hover:text-gray-700 px-2.5 py-1.5 rounded-lg text-xs transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Hapus data?')"
                                                class="text-gray-500 hover:text-red-600 px-2.5 py-1.5 rounded-lg text-xs transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-10 text-gray-500 text-sm">
                                    Belum ada data mahasiswa
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            @if($mahasiswas->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    {{ $mahasiswas->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection