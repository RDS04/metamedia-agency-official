@extends('auth.layout.app')

@section('title', 'Preview Import Mahasiswa')

@section('content')

<div class="space-y-5">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Preview Data Import
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                Periksa data sebelum menyimpan ke database
            </p>
        </div>

    </div>

    <!-- Info Alert -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="flex gap-3">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h3 class="font-medium text-gray-800 text-sm">
                    Total Data: <span class="text-base font-bold">{{ count($data) }}</span> baris
                </h3>
                <p class="text-sm text-gray-600 mt-0.5">
                    Periksa data di bawah. Jika sudah benar, klik tombol "Simpan" untuk menyimpan ke database.
                </p>
            </div>
        </div>
    </div>

    <!-- Preview Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">

        <div class="bg-gray-50 border-b border-gray-200 px-4 py-3">
            <h2 class="font-medium text-sm text-gray-700">
                Data Preview
                <span class="text-gray-400 font-normal ml-2">({{ count($data) }} baris)</span>
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK / NIM</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Pendaftaran</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Daftar Ulang</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sistem Kuliah</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($data as $index => $row)

                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">

                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800 text-xs">
                            {{ $row['nik'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700 text-xs">
                            {{ $row['no_pendaftaran'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700 text-xs">
                            {{ $row['nama_lengkap'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ $row['tanggal_lahir'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ $row['jenis_kelamin'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700 text-xs">
                            {{ $row['program_studi'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2.5 py-0.5 rounded">
                                @if(($row['sistem_kuliah'] ?? '-') === 'Mandiri_transfer')
                                    Mandiri Transfer
                                @else
                                    {{ $row['sistem_kuliah'] ?? '-' }}
                                @endif
                            </span>
                        </td>

                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ $row['periode'] ?? '-' }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-end gap-2">

        <a href="{{ route('mahasiswa.create') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-5 py-2.5 rounded-lg transition-colors text-center">

            Batal
        </a>

        <form action="{{ route('mahasiswa.confirm-import') }}" method="POST" class="inline">

            @csrf

            <button
                type="submit"
                class="bg-gray-800 hover:bg-gray-900 text-white text-sm px-5 py-2.5 rounded-lg transition-colors w-full sm:w-auto">

                Simpan ke Database
            </button>

        </form>

    </div>

</div>

@endsection