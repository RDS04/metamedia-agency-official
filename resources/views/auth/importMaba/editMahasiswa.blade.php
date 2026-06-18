@extends('auth.layout.app')

@section('title', 'Edit Mahasiswa')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-center">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Mahasiswa
            </h1>

            <p class="text-gray-500 mt-1">
                Ubah data mahasiswa
            </p>

        </div>

        <div class="flex gap-3 mt-4 lg:mt-0">

            <a href="{{ route('mahasiswa.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-xl shadow">

                Kembali

            </a>

        </div>

    </div>

    <!-- Form Edit -->
    <div class="bg-white rounded-2xl shadow-sm">

        <div class="border-b px-6 py-4">

            <h2 class="font-semibold text-lg">
                Form Edit Mahasiswa
            </h2>

        </div>

        <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="p-6 grid md:grid-cols-2 gap-6">

                <!-- NIK -->
                <div>

                    <label class="block mb-2 font-medium">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik', $mahasiswa->nik) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('nik') border-red-500 @enderror">

                    @error('nik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- No Pendaftaran -->
                <div>

                    <label class="block mb-2 font-medium">
                        Nomor Pendaftaran
                    </label>

                    <input
                        type="text"
                        name="no_pendaftaran"
                        value="{{ old('no_pendaftaran', $mahasiswa->no_pendaftaran) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('no_pendaftaran') border-red-500 @enderror">

                    @error('no_pendaftaran')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Nama -->
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('nama_lengkap') border-red-500 @enderror">

                    @error('nama_lengkap')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Tanggal Lahir -->
                <div>

                    <label class="block mb-2 font-medium">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir?->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('tanggal_lahir') border-red-500 @enderror">

                    @error('tanggal_lahir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Jenis Kelamin -->
                <div>

                    <label class="block mb-2 font-medium">
                        Jenis Kelamin
                    </label>

                    <div class="flex gap-6 mt-3">

                        <label class="flex items-center">

                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Laki-Laki"
                                {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'Laki-Laki' ? 'checked' : '' }}>

                            <span class="ml-2">
                                Laki-Laki
                            </span>

                        </label>

                        <label class="flex items-center">

                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Perempuan"
                                {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }}>

                            <span class="ml-2">
                                Perempuan
                            </span>

                        </label>

                    </div>

                    @error('jenis_kelamin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Program Studi -->
                <div>

                    <label class="block mb-2 font-medium">
                        Program Studi
                    </label>

                    <select
                        name="program_studi"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('program_studi') border-red-500 @enderror">

                        <option value="">
                            Pilih Program Studi
                        </option>

                        @foreach(\App\Models\Mahasiswa::PROGRAM_STUDI as $prodi)
                            <option value="{{ $prodi }}" {{ old('program_studi', $mahasiswa->program_studi) === $prodi ? 'selected' : '' }}>
                                {{ $prodi }}
                            </option>
                        @endforeach

                    </select>

                    @error('program_studi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Sistem Kuliah -->
                <div>

                    <label class="block mb-2 font-medium">
                        Sistem Kuliah
                    </label>

                    <select
                        name="sistem_kuliah"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('sistem_kuliah') border-red-500 @enderror">

                        <option value="">
                            Pilih Sistem Kuliah
                        </option>

                        <option value="Reguler" {{ old('sistem_kuliah', $mahasiswa->sistem_kuliah) === 'Reguler' ? 'selected' : '' }}>Reguler</option>
                        <option value="Mandiri" {{ old('sistem_kuliah', $mahasiswa->sistem_kuliah) === 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="Mandiri_transfer" {{ old('sistem_kuliah', $mahasiswa->sistem_kuliah) === 'Mandiri_transfer' ? 'selected' : '' }}>Mandiri Transfer</option>
                        <option value="RPL" {{ old('sistem_kuliah', $mahasiswa->sistem_kuliah) === 'RPL' ? 'selected' : '' }}>RPL</option>

                    </select>

                    @error('sistem_kuliah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <!-- Periode -->
                <div>

                    <label class="block mb-2 font-medium">
                        Periode PMB
                    </label>

                    <select
                        name="periode"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 @error('periode') border-red-500 @enderror">

                        <option value="">
                            Pilih Periode
                        </option>

                        <option value="PMB 2026 Gelombang 1" {{ old('periode', $mahasiswa->periode) === 'PMB 2026 Gelombang 1' ? 'selected' : '' }}>PMB 2026 Gelombang 1</option>
                        <option value="PMB 2026 Gelombang 2" {{ old('periode', $mahasiswa->periode) === 'PMB 2026 Gelombang 2' ? 'selected' : '' }}>PMB 2026 Gelombang 2</option>

                    </select>

                    @error('periode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

            </div>

            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <a href="{{ route('mahasiswa.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Batal

                </a>

                <button
                    type="submit"
                    class="bg-[#018FD7] hover:bg-[#0177b4] text-white px-6 py-3 rounded-xl">

                    Update Mahasiswa

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
