@extends('auth.layout.app')

@section('title', 'Komisi Dosen Karyawan')

@section('content')
@php
    $kategori = 'dosen_karyawan';
    $isEdit = $editing !== null;
    $defaults = [
        'nama_skema' => 'Bonus Dosen dan Karyawan',
        'sistem_kuliah' => 'Reguler',
        'target_bonus_ukt' => 4,
        'bonus_pertama' => 125000,
        'bonus_lanjutan' => 250000,
        'bonus_per_mahasiswa' => 0,
        'ukt_per_semester' => null,
        'potongan_ukt_persen' => 10,
        'catatan' => 'Membawa 1 mahasiswa mendapat Bonus Mahasiswa Pertama. Mahasiswa ke-2 dan seterusnya mendapat Bonus Mahasiswa Lanjutan. Total bonus laporan dijumlahkan dari Bonus Mahasiswa Pertama + Bonus Mahasiswa Lanjutan.',
    ];
    $sistemKuliahOptions = [
        'Reguler' => 'Reguler',
        'Mandiri' => 'Mandiri',
        'Mandiri_Transfer' => 'Mandiri Transfer',
        'RPL' => 'Rekognisi Pembelajaran Lampau (RPL)',
    ];
    $ruleSummaries = [
        [
            'title' => 'Bonus Dosen dan Karyawan',
            'items' => [
                'Membawa 1 mahasiswa: hanya mendapat Bonus Mahasiswa Pertama.',
                'Mahasiswa ke-2 dan seterusnya: mendapat Bonus Mahasiswa Lanjutan.',
                'Membawa 4 mahasiswa hingga registrasi ulang: bonus Rp125.000 + (Rp250.000 x 3 mahasiswa) + potongan UKT 10% sampai tamat untuk 1 orang keluarga agent.',
            ],
        ],
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $meta['title'] }}</h1>
            <p class="text-gray-500 mt-1">{{ $meta['description'] }}</p>
        </div>

        @if($isEdit)
            <a href="{{ route('komisi.dosen-karyawan') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                Batal Edit
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            Periksa kembali input skema komisi.
        </div>
    @endif

    <div class="grid lg:grid-cols-1 gap-4">
        @foreach($ruleSummaries as $rule)
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                <h2 class="font-semibold text-gray-800 mb-3">{{ $rule['title'] }}</h2>
                <ul class="space-y-2 text-sm text-gray-700">
                    @foreach($rule['items'] as $item)
                        <li class="flex gap-2">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#018FD7]"></span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-lg">{{ $isEdit ? 'Edit Skema Komisi Dosen/Karyawan' : 'Input Skema Komisi Dosen/Karyawan' }}</h2>
        </div>

        <form action="{{ $isEdit ? route('komisi.update', $editing->id) : route('komisi.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <input type="hidden" name="kategori" value="dosen_karyawan">

            <div class="p-6 grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Skema Dosen/Karyawan</label>
                    <input type="text" name="nama_skema"
                        value="{{ old('nama_skema', $editing->nama_skema ?? $defaults['nama_skema']) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sistem Kuliah</label>
                    <select name="sistem_kuliah" class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">
                        <option value="">-- Pilih Sistem Kuliah --</option>
                        @foreach($sistemKuliahOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('sistem_kuliah', $editing->sistem_kuliah ?? $defaults['sistem_kuliah']) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bonus Mahasiswa Pertama</label>
                    <input type="number" name="bonus_pertama"
                        value="{{ old('bonus_pertama', $editing->bonus_pertama ?? $defaults['bonus_pertama']) }}"
                        placeholder="125000"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bonus Mahasiswa Ke-2 dan Seterusnya</label>
                    <input type="number" name="bonus_lanjutan"
                        value="{{ old('bonus_lanjutan', $editing->bonus_lanjutan ?? $defaults['bonus_lanjutan']) }}"
                        placeholder="250000"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Bonus UKT</label>
                    <input type="number" name="target_bonus_ukt"
                        value="{{ old('target_bonus_ukt', $editing->target_bonus_ukt ?? $defaults['target_bonus_ukt']) }}"
                        placeholder="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">UKT Per Semester</label>
                    <input type="number" name="ukt_per_semester"
                        value="{{ old('ukt_per_semester', $editing->ukt_per_semester ?? $defaults['ukt_per_semester']) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Potongan UKT (%)</label>
                    <input type="number" step="0.01" name="potongan_ukt_persen"
                        value="{{ old('potongan_ukt_persen', $editing->potongan_ukt_persen ?? $defaults['potongan_ukt_persen']) }}"
                        placeholder="10"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Rule Dosen/Karyawan</label>
                    <textarea name="catatan" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('catatan', $editing->catatan ?? $defaults['catatan']) }}</textarea>
                </div>

                <div class="md:col-span-2 flex flex-wrap gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="nominal_fleksibel" value="1"
                            class="w-5 h-5 text-[#018FD7]"
                            {{ old('nominal_fleksibel', $editing->nominal_fleksibel ?? false) ? 'checked' : '' }}>
                        <span class="ml-3">Nominal fleksibel / sesuai MOU</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            class="w-5 h-5 text-[#018FD7]"
                            {{ old('is_active', $editing->is_active ?? true) ? 'checked' : '' }}>
                        <span class="ml-3">Skema aktif</span>
                    </label>
                </div>
            </div>

            <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                <button type="submit" class="bg-[#018FD7] hover:bg-[#0178b7] text-white px-6 py-3 rounded-lg">
                    {{ $isEdit ? 'Update Skema' : 'Simpan Skema' }}
                </button>
            </div>
        </form>
    </div>

    <div class="grid xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-lg">Daftar Skema Dosen/Karyawan</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left">Skema</th>
                            <th class="p-4 text-left">Bonus</th>
                            <th class="p-4 text-left">Benefit UKT</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($komisis as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4">
                                    <p class="font-semibold text-gray-800">{{ $item->nama_skema }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->sistem_kuliah ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $item->is_active ? 'Aktif' : 'Non aktif' }}</p>
                                </td>
                                <td class="p-4 text-sm text-gray-700">
                                    @if($item->nominal_fleksibel)
                                        Tidak dicantumkan
                                    @elseif($item->bonus_per_mahasiswa > 0)
                                        Rp{{ number_format($item->bonus_per_mahasiswa, 0, ',', '.') }} / mahasiswa
                                    @else
                                        Pertama Rp{{ number_format($item->bonus_pertama, 0, ',', '.') }},
                                        lanjutan Rp{{ number_format($item->bonus_lanjutan, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-700">
                                    @if($item->target_bonus_ukt && $item->potongan_ukt_persen)
                                        <p>{{ $item->potongan_ukt_persen }}% setelah {{ $item->target_bonus_ukt }} mahasiswa</p>
                                        <p class="text-xs text-gray-500">Sampai tamat untuk 1 keluarga agent</p>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ request()->url() }}?edit={{ $item->id }}"
                                            class="px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 text-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('komisi.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus skema komisi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 rounded-lg bg-red-100 text-red-700 text-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500">
                                    Belum ada skema komisi dosen/karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-lg">Simulasi Bonus Dosen/Karyawan</h2>
            </div>

            <form method="GET" action="{{ request()->url() }}" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Skema</label>
                    <select name="komisi_id" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        <option value="">-- Pilih Skema --</option>
                        @foreach($komisis as $item)
                            <option value="{{ $item->id }}" {{ request('komisi_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_skema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Registrasi Ulang</label>
                    <input type="number" name="jumlah_mahasiswa" min="0"
                        value="{{ request('jumlah_mahasiswa', 0) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white px-4 py-3 rounded-lg">
                    Hitung Bonus
                </button>
            </form>

            @if($simulasi)
                <div class="border-t p-6 space-y-3">
                    <p class="text-sm text-gray-500">Hasil Simulasi</p>
                    <p class="text-xl font-bold text-gray-800">
                        @if($simulasi['total_bonus'] === null)
                            Nominal tidak dicantumkan
                        @else
                            Rp{{ number_format($simulasi['total_bonus'], 0, ',', '.') }}
                        @endif
                    </p>

                    @if($simulasi['bonus_ukt'])
                        <p class="text-sm text-green-700 bg-green-50 border border-green-100 rounded-lg p-3">
                            Berhak potongan UKT {{ $simulasi['komisi']->potongan_ukt_persen }}% sampai tamat untuk 1 keluarga agent.
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
