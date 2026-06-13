@extends('auth.layout.app')

@section('title', 'Tambah Agent')

@section('content')

    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold text-black">
                    Tambah Agent
                </h1>

                <p class="text-gray-400 mt-1">
                    Tambahkan data agent baru ke dalam sistem
                </p>
            </div>

            <a href="{{ route('Add.agent') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                ← Kembali
            </a>

        </div>

        <!-- Card Form -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden">

            <div class="border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-[#018FD7] to-[#0177BB]">

                <h2 class="text-white text-lg font-semibold">
                    Form Tambah Agent Baru
                </h2>

            </div>

            <form action="" method="POST">
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

                            <select name="jenis_kelamin" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="Laki-Laki">
                                    Laki-Laki
                                </option>

                                <option value="Perempuan">
                                    Perempuan
                                </option>

                            </select>
                        </div>

                        <!-- Prodi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Program Studi
                            </label>

                            <select name="program_studi" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option name="">
                                    -- Pilih Program Studi --
                                </option>

                                <option name="Sistem Informasi">
                                    Sistem Informasi
                                </option>

                                <option name="Informatika">
                                    Informatika
                                </option>

                                <option name="Bisnis Digital">
                                    Bisnis Digital
                                </option>

                                <option name="Desain Komunikasi Visual">
                                    Desain Komunikasi Visual
                                </option>

                                <option name="Pendidikan Teknologi Informasi">
                                    Pendidikan Teknologi Informasi
                                </option>

                                <option name="Manajemen Ritel">
                                    Manajemen Ritel
                                </option>

                            </select>
                        </div>

                        <!-- Sistem Kuliah -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sistem Kuliah
                            </label>

                            <select name="sistem_kuliah" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option value="">
                                    -- Pilih Sistem Kuliah --
                                </option>

                                <option value="Reguler">
                                    Reguler
                                </option>

                                <option value="Mandiri">
                                    Mandiri
                                </option>

                                <option value="RPL">
                                    Rekognisi Pembelajaran Lampau
                                </option>

                            </select>
                        </div>

                        <!-- Periode -->
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Periode
                            </label>

                            <select name="periode" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 outline-none transition">

                                <option value="">
                                    -- Pilih Periode --
                                </option>

                                <option value="2026 Ganjil">
                                    2026 Ganjil
                                </option>

                                <option value="2026 Genap">
                                    2026 Genap
                                </option>

                                <option value="2027 Ganjil">
                                    2027 Ganjil
                                </option>

                                <option value="2027 Genap">
                                    2027 Genap
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="bg-gray-100 px-8 py-4 border-t border-gray-200 flex justify-end gap-3">

                    <a href="" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition">
                        Batal
                    </a>

                    <button type="submit" class="px-6 py-2 bg-[#018FD7] hover:bg-[#0177BB] text-white rounded-lg font-medium shadow transition">
                        Simpan Agent
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection