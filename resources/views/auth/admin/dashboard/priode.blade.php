@extends('auth.layout.app')

@section('title', 'Setting PMB')

@section('content')

@php
    $isEdit = isset($periode);
@endphp

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Setting Periode PMB
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola periode penerimaan mahasiswa baru
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            Periksa kembali data periode yang diinputkan.
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm">
        <div class="border-b px-6 py-4">
            <h2 class="font-semibold text-lg">
                {{ $isEdit ? 'Edit Periode PMB' : 'Form Periode PMB' }}
            </h2>
        </div>

        <form action="{{ $isEdit ? route('periode.update', $periode->id) : route('periode.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="p-6 grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Periode
                    </label>

                    <input type="text" name="nama_periode" placeholder="PMB 2026 Gelombang 1"
                        value="{{ old('nama_periode', $periode->nama_periode ?? '') }}"
                        class="w-full border @error('nama_periode') border-red-300 bg-red-50 @else border-gray-300 @enderror rounded-xl px-4 py-3">

                    @error('nama_periode')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Tahun
                    </label>

                    <input type="number" name="tahun"
                        value="{{ old('tahun', $periode->tahun ?? date('Y')) }}"
                        class="w-full border @error('tahun') border-red-300 bg-red-50 @else border-gray-300 @enderror rounded-xl px-4 py-3">

                    @error('tahun')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Tanggal Mulai
                    </label>

                    <input type="date" name="tanggal_mulai"
                        value="{{ old('tanggal_mulai', isset($periode) ? $periode->tanggal_mulai->format('Y-m-d') : '') }}"
                        class="w-full border @error('tanggal_mulai') border-red-300 bg-red-50 @else border-gray-300 @enderror rounded-xl px-4 py-3">

                    @error('tanggal_mulai')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Tanggal Selesai
                    </label>

                    <input type="date" name="tanggal_selesai"
                        value="{{ old('tanggal_selesai', isset($periode) ? $periode->tanggal_selesai->format('Y-m-d') : '') }}"
                        class="w-full border @error('tanggal_selesai') border-red-300 bg-red-50 @else border-gray-300 @enderror rounded-xl px-4 py-3">

                    @error('tanggal_selesai')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            class="w-5 h-5 text-[#018FD7]"
                            {{ old('is_active', $periode->is_active ?? false) ? 'checked' : '' }}>

                        <span class="ml-3">
                            Jadikan Periode Aktif
                        </span>
                    </label>
                </div>
            </div>

            <div class="border-t px-6 py-4 flex justify-end gap-3">
                @if($isEdit)
                    <a href="{{ route('priode') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">
                        Batal
                    </a>
                @endif

                <button type="submit"
                    class="bg-[#018FD7] hover:bg-[#0178b7] text-white px-6 py-3 rounded-xl">
                    {{ $isEdit ? 'Update Periode' : 'Simpan Periode' }}
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="border-b px-6 py-4">
            <h2 class="font-semibold text-lg">
                List Periode PMB
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left">Nama Periode</th>
                        <th class="p-4 text-left">Tahun</th>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($periodes as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $item->nama_periode }}
                            </td>
                            <td class="p-4">
                                {{ $item->tahun }}
                            </td>
                            <td class="p-4 text-gray-600">
                                {{ $item->tanggal_mulai->format('d M Y') }} - {{ $item->tanggal_selesai->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                @if($item->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Aktif
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        Non Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('periode.edit', $item->id) }}"
                                        class="bg-yellow-100 text-yellow-700 px-3 py-2 rounded-lg text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('periode.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus periode ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Belum ada periode PMB.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
