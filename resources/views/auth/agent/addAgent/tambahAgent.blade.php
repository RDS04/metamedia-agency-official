@extends('auth.layout.app')

@section('title', 'Input Mahasiswa')

@section('content')

<div class="space-y-5">

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-red-800 text-sm">Terjadi Kesalahan</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
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
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-green-800 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-red-800 text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Input Mahasiswa
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                Tambah calon mahasiswa baru yang Anda daftarkan
            </p>
        </div>
    </div>

    <!-- Import Data Excel Card -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-4 py-3">
            <h2 class="font-medium text-sm text-gray-700">
                Import Data Excel
            </h2>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="p-4" onsubmit="alert('Silakan gunakan Form Input Mahasiswa di bawah ini untuk menambahkan calon mahasiswa.'); return false;">
            @csrf
            <div class="flex flex-col lg:flex-row gap-3">
                <input
                    type="file"
                    name="file"
                    accept=".xlsx,.xls,.csv"
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">

                <button
                    type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white text-sm px-5 py-2 rounded-lg transition-colors font-medium">
                    Import Excel
                </button>
            </div>
        </form>
    </div>

    <!-- Form Input Mahasiswa Card -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-4 py-3">
            <h2 class="font-medium text-sm text-gray-700">
                Form Input Mahasiswa
            </h2>
        </div>

        <form action="{{ route('agen.Store') }}" method="POST">
            @csrf

            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        NIK <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        placeholder="Masukkan NIK"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('nik') border-red-500 @enderror">
                    @error('nik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP / WhatsApp -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nomor HP / WhatsApp <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="nomor_hp"
                        value="{{ old('nomor_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('nomor_hp') border-red-500 @enderror">
                    @error('nomor_hp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        placeholder="Masukkan nama lengkap calon mahasiswa"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('nama_lengkap') border-red-500 @enderror">
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>

                    <div class="flex gap-6 mt-2">
                        <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Laki-Laki"
                                {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }}
                                class="w-4 h-4 text-gray-700 border-gray-300 focus:ring-gray-400">
                            <span class="ml-2">Laki-Laki</span>
                        </label>

                        <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Perempuan"
                                {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}
                                class="w-4 h-4 text-gray-700 border-gray-300 focus:ring-gray-400">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program Studi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Program Studi <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="program_studi"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('program_studi') border-red-500 @enderror">
                        <option value="">Pilih Program Studi</option>
                        <option value="Sistem Informasi" {{ old('program_studi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="Informatika" {{ old('program_studi') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                        <option value="Bisnis Digital" {{ old('program_studi') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                        <option value="Desain Komunikasi Visual" {{ old('program_studi') == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                        <option value="Pendidikan Teknologi Informasi" {{ old('program_studi') == 'Pendidikan Teknologi Informasi' ? 'selected' : '' }}>Pendidikan Teknologi Informasi</option>
                        <option value="Manajemen Ritel" {{ old('program_studi') == 'Manajemen Ritel' ? 'selected' : '' }}>Manajemen Ritel</option>
                    </select>
                    @error('program_studi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sistem Kuliah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Sistem Kuliah <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="sistem_kuliah"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('sistem_kuliah') border-red-500 @enderror">
                        <option value="">Pilih Sistem Kuliah</option>
                        <option value="Reguler" {{ old('sistem_kuliah') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                        <option value="Mandiri" {{ old('sistem_kuliah') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="Mandiri_Transfer" {{ old('sistem_kuliah') == 'Mandiri_Transfer' ? 'selected' : '' }}>Mandiri Transfer</option>
                        <option value="RPL" {{ old('sistem_kuliah') == 'RPL' ? 'selected' : '' }}>RPL (Rekognisi Pembelajaran Lampau)</option>
                    </select>
                    @error('sistem_kuliah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Periode PMB -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Periode PMB <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="periode"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 @error('periode') border-red-500 @enderror">
                        <option value="">Pilih Periode</option>
                        @if(isset($periodes) && count($periodes) > 0)
                            @foreach($periodes as $p)
                                <option value="{{ $p->nama_periode }}" {{ old('periode') == $p->nama_periode ? 'selected' : '' }}>
                                    {{ $p->nama_periode }} - {{ $p->tahun }} {{ $p->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        @else
                            <option value="PMB 2026 Gelombang 1" {{ old('periode') == 'PMB 2026 Gelombang 1' ? 'selected' : '' }}>PMB 2026 Gelombang 1</option>
                            <option value="PMB 2026 Gelombang 2" {{ old('periode') == 'PMB 2026 Gelombang 2' ? 'selected' : '' }}>PMB 2026 Gelombang 2</option>
                        @endif
                    </select>
                    @error('periode')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 flex flex-col sm:flex-row justify-end gap-2">
                <button
                    type="reset"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-5 py-2 rounded-lg transition-colors font-medium">
                    Reset
                </button>

                <button
                    type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white text-sm px-5 py-2 rounded-lg transition-colors font-medium">
                    Simpan Mahasiswa
                </button>
            </div>

        </form>
    </div>

</div>

@endsection