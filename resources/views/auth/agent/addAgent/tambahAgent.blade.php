@extends('auth.layout.app')

@section('title', 'Tambah Agent')

@section('content')

    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold text-black">
                    Tambah Calon Mahasiswa
                </h1>

                <p class="text-gray-400 mt-1">
                    Tambahkan data calon mahasiswa baru ke dalam sistem
                </p>
            </div>

            <a href="{{ route('agen.Create') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                ← Kembali
            </a>

        </div>

        @if($targetBonusUkt)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-6 py-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $isMitra ? 'Progress Bonus Mitra' : 'Progress Potongan UKT' }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            @if($isMitra)
                                Anda memiliki {{ $targetProgressCount }} dari target {{ $targetBonusUkt }} mahasiswa registrasi ulang.
                            @else
                                Anda sudah mendaftarkan {{ $targetProgressCount }} dari target {{ $targetBonusUkt }} calon mahasiswa.
                            @endif
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="min-w-48">
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#018FD7] rounded-full"
                                    style="width: {{ min(100, round(($targetProgressCount / max(1, $targetBonusUkt)) * 100)) }}%">
                                </div>
                            </div>
                        </div>

                        @if($potonganUktTercapai)
                            <span class="inline-flex items-center justify-center rounded-lg bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                                @if($isMitra)
                                    Bonus Rp {{ number_format($komisiAktif->bonus_pertama, 0, ',', '.') }} tercapai
                                @else
                                    Potongan UKT {{ $komisiAktif->potongan_ukt_persen }}% aktif
                                @endif
                            </span>
                        @elseif($akanTercapaiSetelahSimpan)
                            <span class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                                Simpan 1 camaba lagi untuk aktif
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                                Kurang {{ $sisaTargetUkt }} {{ $isMitra ? 'registrasi ulang' : 'camaba' }} lagi
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Card Form -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden">

            <div class="border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-[#018FD7] to-[#0177BB]">

                <h2 class="text-white text-lg font-semibold">
                    Form Tambah Calon Mahasiswa
                </h2>

            </div>
            <form action="{{ route('agen.Store') }}" method="POST">
                @csrf
                <div class="p-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>

                        <!-- NIK -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                NIK
                            </label>

                            <input type="text" name="nik" placeholder="Masukkan NIK"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor HP
                            </label>

                            <input type="text" name="nomor_hp" placeholder="08xxxxxxxxxx"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Kelamin
                            </label>

                            <div>
                                <div class="flex gap-6">

                                    <label class="flex items-center cursor-pointer">

                                        <input type="radio" name="jenis_kelamin" value="Laki-Laki"
                                            class="w-4 h-4 text-[#018FD7] border-gray-300 focus:ring-[#018FD7]" {{
        old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }}>

                                        <span class="ml-2 text-gray-700">
                                            Laki-Laki
                                        </span>

                                    </label>

                                    <label class="flex items-center cursor-pointer">

                                        <input type="radio" name="jenis_kelamin" value="Perempuan"
                                            class="w-4 h-4 text-[#018FD7] border-gray-300 focus:ring-[#018FD7]" {{
        old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>

                                        <span class="ml-2 text-gray-700">
                                            Perempuan
                                        </span>

                                    </label>

                                </div>

                                @error('jenis_kelamin')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>
                        </div>

                        <!-- Prodi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Program Studi
                            </label>

                            <select name="program_studi"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option value="">
                                    -- Pilih Program Studi --
                                </option>

                                <option value="Sistem Informasi">
                                    Sistem Informasi
                                </option>

                                <option value="Informatika">
                                    Informatika
                                </option>

                                <option value="Bisnis Digital">
                                    Bisnis Digital
                                </option>

                                <option value="Desain Komunikasi Visual">
                                    Desain Komunikasi Visual
                                </option>

                                <option value="Pendidikan Teknologi Informasi">
                                    Pendidikan Teknologi Informasi
                                </option>

                                <option value="Manajemen Ritel">
                                    Manajemen Ritel
                                </option>

                            </select>
                        </div>

                        <!-- Sistem Kuliah -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sistem Kuliah
                            </label>

                            <select name="sistem_kuliah"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option value="">
                                    -- Pilih Sistem Kuliah --
                                </option>   
                                <option value="Reguler">Reguler</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="Mandiri_Transfer">Mandiri Transfer</option>
                                <option value="RPL">Rekognisi Pembelajaran Lampau (RPL)</option>

                            </select>
                        </div>

                        <!-- Periode -->
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Periode
                            </label>

                            <select name="periode"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option value="">
                                    -- Pilih Periode --
                                </option>

                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->nama_periode }}"
                                        {{ old('periode') == $periode->nama_periode ? 'selected' : '' }}>
                                        {{ $periode->nama_periode }} - {{ $periode->tahun }}
                                        {{ $periode->is_active ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach

                            </select>

                            @error('periode')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                <div class="bg-gray-100 px-8 py-4 border-t border-gray-200 flex justify-end gap-3">

                    <a href="" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-2 bg-[#018FD7] hover:bg-[#0177BB] text-white rounded-lg font-medium shadow transition">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
