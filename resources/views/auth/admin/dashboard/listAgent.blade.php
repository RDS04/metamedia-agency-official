@extends('auth.layout.app')

@section('title', 'Data Agent')

@section('content')

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Data Agent
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola seluruh agent PMB
                </p>

            </div>

            <a href="{{ route('agen.Create') }}"
                class="mt-4 md:mt-0 bg-[#018FD7] hover:bg-[#0177b5] text-white px-5 py-3 rounded-xl shadow">

                + Tambah Agent

            </a>

        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm p-5">

            <div class="grid md:grid-cols-4 gap-4">

                <!-- Search -->
                <div>

                    <input type="text" placeholder="Cari Agent..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3">

                </div>

                <!-- Role -->
                <div>

                    <select class="w-full border border-gray-300 rounded-xl px-4 py-3">

                        <option>
                            Semua Role
                        </option>

                        <option>
                            Mahasiswa
                        </option>

                        <option>
                            Alumni
                        </option>

                        <option>
                            Orang Tua
                        </option>

                        <option>
                            Dosen
                        </option>

                        <option>
                            Karyawan
                        </option>

                        <option>
                            Mitra
                        </option>

                    </select>

                </div>

                <!-- Status -->
                <div>

                    <select class="w-full border border-gray-300 rounded-xl px-4 py-3">

                        <option>
                            Semua Status
                        </option>

                        <option>
                            Aktif
                        </option>

                        <option>
                            Non Aktif
                        </option>

                    </select>

                </div>

                <div>

                    <button class="w-full bg-gray-800 text-white py-3 rounded-xl">

                        Filter

                    </button>

                </div>

            </div>

        </div>

        <!-- Tabel -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="p-5 border-b">

                <h2 class="font-semibold text-lg">
                    List Agent
                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="p-4 text-left">
                                Nama
                            </th>

                            <th class="p-4 text-left">
                                Role
                            </th>

                            <th class="p-4 text-left">
                                No HP
                            </th>

                            <th class="p-4 text-left">
                                Referral
                            </th>

                            <th class="p-4 text-left">
                                Status
                            </th>

                            <th class="p-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($agents as $agent)

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-4">

                                    <div>

                                        <h4 class="font-semibold">

                                            {{ $agent->name }}

                                        </h4>

                                        <p class="text-sm text-gray-500">

                                            {{ $agent->email }}

                                        </p>

                                    </div>

                                </td>

                                <td class="p-4">

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                                        {{ ucwords(str_replace('_', ' ', $agent->role_agent)) }}

                                    </span>

                                </td>

                                <td class="p-4">

                                    {{ $agent->phone }}

                                </td>

                                <td class="p-4">

                                    <span class="font-mono">

                                        {{ $agent->kode_referral }}

                                    </span>

                                </td>

                                <td class="p-4">

                                    @if($agent->is_active)

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                            Aktif

                                        </span>

                                    @else

                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                            Non Aktif

                                        </span>

                                    @endif

                                </td>

                                <td class="p-4">

                                    <div class="flex justify-center gap-2">

                                        <!-- Detail -->
                                        <a href="{{ route('agen.Show', $agent->id) }}"
                                            class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg text-sm">

                                            Detail

                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('agen.Edit', $agent->id) }}"
                                            class="bg-yellow-100 text-yellow-700 px-3 py-2 rounded-lg text-sm">

                                            Edit

                                        </a>

                                        <!-- Toggle Status -->
                                        <form action="{{ route('agent.toggle', $agent->id) }}" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            @if($agent->is_active)

                                                <button class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm">

                                                    Non Aktifkan

                                                </button>

                                            @else

                                                <button class="bg-green-100 text-green-700 px-3 py-2 rounded-lg text-sm">

                                                    Aktifkan

                                                </button>

                                            @endif

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection