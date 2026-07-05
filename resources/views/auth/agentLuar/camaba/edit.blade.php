@extends('auth.layout.app')

@section('title', 'Edit Camaba')
@section('page-title', 'Edit Calon Mahasiswa')

@section('content')

    <div class="max-w-2xl">

        <a href="{{ route('agent-luar.camaba.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 mb-5 transition">
            <i class="ti ti-arrow-left text-base"></i>
            Kembali ke Daftar
        </a>

        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-semibold text-slate-800">Edit Data Camaba</h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $camaba->nama_lengkap }}</p>
            </div>

            <form action="{{ route('agent-luar.camaba.update', $camaba->id) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $camaba->nama_lengkap) }}"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100">
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik" value="{{ old('nik', $camaba->nik) }}"
                            maxlength="16"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100">
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nomor HP / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $camaba->nomor_hp) }}"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 bg-white">
                            <option value="Laki-Laki"  {{ old('jenis_kelamin', $camaba->jenis_kelamin) === 'Laki-Laki'  ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan"  {{ old('jenis_kelamin', $camaba->jenis_kelamin) === 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Program Studi -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Program Studi <span class="text-red-500">*</span>
                        </label>
                        <select name="program_studi"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 bg-white">
                            @foreach([
                                'S1 Teknik Informatika','S1 Sistem Informasi','S1 Bisnis Digital',
                                'S1 Desain Komunikasi Visual','S1 Manajemen','S1 Akuntansi',
                                'D3 Teknik Informatika','D3 Sistem Informasi'
                            ] as $prodi)
                                <option value="{{ $prodi }}" {{ old('program_studi', $camaba->program_studi) === $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sistem Kuliah -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Sistem Kuliah <span class="text-red-500">*</span>
                        </label>
                        <select name="sistem_kuliah"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 bg-white">
                            @foreach(['Reguler','Mandiri','Mandiri_Transfer','RPL'] as $sk)
                                <option value="{{ $sk }}" {{ old('sistem_kuliah', $camaba->sistem_kuliah) === $sk ? 'selected' : '' }}>{{ str_replace('_', ' ', $sk) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Periode -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Periode <span class="text-red-500">*</span>
                        </label>
                        <select name="periode"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-[#018FD7] focus:ring-2 focus:ring-blue-100 bg-white">
                            @foreach($periodes as $p)
                                <option value="{{ $p->nama_periode }}"
                                    {{ old('periode', $camaba->periode) === $p->nama_periode ? 'selected' : '' }}>
                                    {{ $p->nama_periode }} {{ $p->tahun }}
                                    @if($p->is_active) (Aktif) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-[#018FD7] hover:bg-[#0073b1] text-white font-semibold text-sm rounded-xl transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('agent-luar.camaba.show', $camaba->id) }}"
                        class="px-6 py-2.5 border border-slate-200 text-slate-600 text-sm rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>

@endsection
