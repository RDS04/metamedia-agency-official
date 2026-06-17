@extends('auth.layout.app')

@section('title', 'Edit Agent')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center">

        <div>
            <h1 class="text-3xl font-bold text-black">
                Edit Agent
            </h1>

            <p class="text-gray-400 mt-1">
                Perbarui data agent
            </p>
        </div>

        <a href="{{ route('agen.Show') }}"
            class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            ← Kembali
        </a>

    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden">

        <div class="border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-[#018FD7] to-[#0177BB]">

            <h2 class="text-white text-lg font-semibold">
                Form Edit Agent
            </h2>

        </div>

        <form action="{{ route('agen.Update', $agent->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                            value="{{ old('nama_lengkap', $agent->nama_lengkap) }}"
                            class="w-full rounded-lg border @error('nama_lengkap') border-red-300 bg-red-50 @else border-gray-300 @enderror px-4 py-3 text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            NIK
                        </label>

                        <input type="text" name="nik" placeholder="Masukkan NIK"
                            value="{{ old('nik', $agent->nik) }}"
                            class="w-full rounded-lg border @error('nik') border-red-300 bg-red-50 @else border-gray-300 @enderror px-4 py-3 text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        @error('nik')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor HP
                        </label>

                        <input type="text" name="nomor_hp" placeholder="08xxxxxxxxxx"
                            value="{{ old('nomor_hp', $agent->nomor_hp) }}"
                            class="w-full rounded-lg border @error('nomor_hp') border-red-300 bg-red-50 @else border-gray-300 @enderror px-4 py-3 text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        @error('nomor_hp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kelamin
                        </label>

                        <div class="flex gap-6">

                            <label class="flex items-center cursor-pointer">

                                <input type="radio" name="jenis_kelamin" value="Laki-Laki"
                                    class="w-4 h-4 text-[#018FD7] border-gray-300 focus:ring-[#018FD7]"
                                    {{ old('jenis_kelamin', $agent->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}>

                                <span class="ml-2 text-gray-700">Laki-Laki</span>

                            </label>

                            <label class="flex items-center cursor-pointer">

                                <input type="radio" name="jenis_kelamin" value="Perempuan"
                                    class="w-4 h-4 text-[#018FD7] border-gray-300 focus:ring-[#018FD7]"
                                    {{ old('jenis_kelamin', $agent->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>

                                <span class="ml-2 text-gray-700">Perempuan</span>

                            </label>

                        </div>

                        @error('jenis_kelamin')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Prodi -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Program Studi
                        </label>

                        <select name="program_studi"
                            class="w-full rounded-lg border @error('program_studi') border-red-300 bg-red-50 @else border-gray-300 @enderror px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                            <option value="">-- Pilih Program Studi --</option>
                            <option value="Sistem Informasi" {{ old('program_studi', $agent->program_studi) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Informatika" {{ old('program_studi', $agent->program_studi) == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                            <option value="Bisnis Digital" {{ old('program_studi', $agent->program_studi) == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                            <option value="Desain Komunikasi Visual" {{ old('program_studi', $agent->program_studi) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                            <option value="Pendidikan Teknologi Informasi" {{ old('program_studi', $agent->program_studi) == 'Pendidikan Teknologi Informasi' ? 'selected' : '' }}>Pendidikan Teknologi Informasi</option>
                            <option value="Manajemen Ritel" {{ old('program_studi', $agent->program_studi) == 'Manajemen Ritel' ? 'selected' : '' }}>Manajemen Ritel</option>

                        </select>

                        @error('program_studi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Sistem Kuliah -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sistem Kuliah
                        </label>

                        <select name="sistem_kuliah"
                            class="w-full rounded-lg border @error('sistem_kuliah') border-red-300 bg-red-50 @else border-gray-300 @enderror px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                            <option value="">-- Pilih Sistem Kuliah --</option>
                            <option value="Reguler" {{ old('sistem_kuliah', $agent->sistem_kuliah) == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="Mandiri" {{ old('sistem_kuliah', $agent->sistem_kuliah) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            <option value="Mandiri_Transfer" {{ old('sistem_kuliah', $agent->sistem_kuliah) == 'Mandiri_Transfer' ? 'selected' : '' }}>Mandiri Transfer</option>
                            <option value="RPL" {{ old('sistem_kuliah', $agent->sistem_kuliah) == 'RPL' ? 'selected' : '' }}>Rekognisi Pembelajaran Lampau</option>

                        </select>

                        @error('sistem_kuliah')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Periode -->
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Periode
                        </label>

                        <select name="periode"
                            class="w-full rounded-lg border @error('periode') border-red-300 bg-red-50 @else border-gray-300 @enderror px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                            <option value="">-- Pilih Periode --</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->nama_periode }}"
                                    {{ old('periode', $agent->periode) == $periode->nama_periode ? 'selected' : '' }}>
                                    {{ $periode->nama_periode }} - {{ $periode->tahun }}
                                    {{ $periode->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach

                        </select>

                        @error('periode')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="bg-gray-100 px-8 py-4 border-t border-gray-200 flex justify-end gap-3">

                <a href="{{ route('agen.Show') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-[#018FD7] hover:bg-[#0177BB] text-white rounded-lg font-medium shadow transition">
                    Perbarui Agent
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
