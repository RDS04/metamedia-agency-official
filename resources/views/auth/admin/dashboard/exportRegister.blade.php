@extends('auth.layout.app')

@section('title', 'Registrasi Agent via Excel')

@section('content')

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                colors: {
                    brand: {
                        50:  '#e6f4fc',
                        100: '#b3ddf5',
                        300: '#4db3e8',
                        400: '#1a9fd9',
                        600: '#018FD7',
                        700: '#0175b2',
                        800: '#015d8e',
                        900: '#003f61',
                    }
                }
            }
        }
    }
</script>

<style>
    body { font-family: 'Inter', sans-serif; }

    /* Drag-drop zone */
    .dropzone {
        border: 2px dashed #b3ddf5;
        transition: border-color 0.2s, background 0.2s;
    }
    .dropzone.dragover {
        border-color: #018FD7;
        background: #e6f4fc;
    }

    /* Table scroll */
    .preview-table-wrap {
        overflow-x: auto;
    }

    /* Status badge */
    .badge-valid   { background:#dcfce7; color:#15803d; }
    .badge-invalid { background:#fee2e2; color:#b91c1c; }

    /* Animated progress bar */
    @keyframes progress-in {
        from { width: 0; }
    }
    .progress-bar { animation: progress-in 0.8s ease-out forwards; }

    /* Hover card lift */
    .stat-card { transition: transform 0.18s, box-shadow 0.18s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(1,143,215,0.13); }
</style>

{{-- ── Topbar ── --}}
<header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0 z-10">
    <div>
        <h1 class="text-sm font-semibold text-slate-800">Registrasi Agent via Excel</h1>
        <p class="text-xs text-slate-400">Import & daftarkan agent sekaligus dari file Excel</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('exportregister.template') }}"
           class="flex items-center gap-1.5 text-xs border border-brand-600 text-brand-600 px-3 py-1.5 rounded-md hover:bg-brand-50 transition-colors font-medium">
            <i class="ti ti-file-spreadsheet text-sm"></i>
            Download Template
        </a>
        <a href="{{ route('listAgent') }}"
           class="flex items-center gap-1.5 text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-md hover:bg-slate-200 transition-colors">
            <i class="ti ti-arrow-left text-sm"></i>
            Kembali
        </a>
        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">
            <i class="ti ti-bell text-base"></i>
        </button>
    </div>
</header>

{{-- ── Page Body ── --}}
<main class="flex-1 p-6 space-y-6">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i class="ti ti-circle-check text-lg mt-0.5 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <i class="ti ti-alert-circle text-lg mt-0.5 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <i class="ti ti-alert-circle text-lg mt-0.5 shrink-0"></i>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAHAP 1 — Upload Form (tampil jika belum ada preview)
    ══════════════════════════════════════════════════════════ --}}
    @if(!isset($preview))

    <!-- Tabs Navigation -->
    <div class="flex border-b border-slate-100 mb-6">
        <button id="tabExcelBtn" onclick="switchTab('excel')" class="px-5 py-2.5 font-semibold text-sm border-b-2 border-brand-600 text-brand-600 focus:outline-none flex items-center gap-2">
            <i class="ti ti-file-spreadsheet text-base"></i>Import via Excel
        </button>
        <button id="tabManualBtn" onclick="switchTab('manual')" class="px-5 py-2.5 font-semibold text-sm border-b-2 border-transparent text-slate-500 hover:text-slate-800 focus:outline-none flex items-center gap-2">
            <i class="ti ti-user-plus text-base"></i>Input Manual
        </button>
    </div>

    <!-- Excel Input Tab Content -->
    <div id="excelTabContent" class="space-y-6">
        {{-- Panduan Kolom Excel --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center">
                    <i class="ti ti-info-circle text-brand-600 text-base"></i>
                </div>
                <h2 class="text-sm font-semibold text-slate-800">Format Excel yang Diperlukan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-brand-600 text-white">
                            <th class="px-4 py-2.5 text-left rounded-tl-lg font-medium">Kolom</th>
                            <th class="px-4 py-2.5 text-left font-medium">Nama Header</th>
                            <th class="px-4 py-2.5 text-left font-medium">Contoh Nilai</th>
                            <th class="px-4 py-2.5 text-left rounded-tr-lg font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 font-mono text-brand-600 font-semibold">A</td>
                            <td class="px-4 py-2.5 font-mono text-slate-700">name</td>
                            <td class="px-4 py-2.5 text-slate-500">Budi Santoso</td>
                            <td class="px-4 py-2.5 text-slate-500">Nama lengkap agent <span class="text-red-500">*</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 font-mono text-brand-600 font-semibold">B</td>
                            <td class="px-4 py-2.5 font-mono text-slate-700">email</td>
                            <td class="px-4 py-2.5 text-slate-500">budi@email.com</td>
                            <td class="px-4 py-2.5 text-slate-500">Alamat email unik <span class="text-red-500">*</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 font-mono text-brand-600 font-semibold">C</td>
                            <td class="px-4 py-2.5 font-mono text-slate-700">phone</td>
                            <td class="px-4 py-2.5 text-slate-500">081234567890</td>
                            <td class="px-4 py-2.5 text-slate-500">Nomor WhatsApp unik <span class="text-red-500">*</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 font-mono text-brand-600 font-semibold">D</td>
                            <td class="px-4 py-2.5 font-mono text-slate-700">status</td>
                            <td class="px-4 py-2.5 text-slate-500">mahasiswa</td>
                            <td class="px-4 py-2.5 text-slate-500">mahasiswa / alumni / orang_tua / dosen_karyawan / mitra <span class="text-red-500">*</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 font-mono text-brand-600 font-semibold">E</td>
                            <td class="px-4 py-2.5 font-mono text-slate-700">password</td>
                            <td class="px-4 py-2.5 text-slate-500">password123</td>
                            <td class="px-4 py-2.5 text-slate-500">Password awal agent <span class="text-red-500">*</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="mt-3 text-xs text-slate-400"><span class="text-red-500">*</span> Wajib diisi. Baris dengan data tidak valid akan dilewati.</p>
        </div>

        {{-- Upload Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center">
                    <i class="ti ti-upload text-brand-600 text-base"></i>
                </div>
                <h2 class="text-sm font-semibold text-slate-800">Upload File Excel</h2>
            </div>

            <form action="{{ route('exportregister.preview') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf

                {{-- Drop Zone --}}
                <div id="dropzone"
                     class="dropzone rounded-2xl p-10 flex flex-col items-center justify-center gap-3 cursor-pointer bg-slate-50 mb-5"
                     onclick="document.getElementById('fileInput').click()">

                    <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center">
                        <i class="ti ti-file-spreadsheet text-brand-600 text-3xl"></i>
                    </div>

                    <div class="text-center">
                        <p class="text-sm font-semibold text-slate-700">Klik atau seret file ke sini</p>
                        <p class="text-xs text-slate-400 mt-1">Format: .xlsx, .xls, .csv — Maks. 5 MB</p>
                    </div>

                    {{-- File name preview --}}
                    <div id="fileNameDisplay" class="hidden items-center gap-2 text-xs font-medium text-brand-600 bg-brand-50 px-3 py-1.5 rounded-lg">
                        <i class="ti ti-file-check text-base"></i>
                        <span id="fileNameText"></span>
                    </div>

                    <input type="file" id="fileInput" name="file" accept=".xlsx,.xls,.csv" class="hidden">
                </div>

                {{-- Submit --}}
                <button type="submit" id="submitBtn"
                        class="w-full flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    <i class="ti ti-search text-base" id="btnIcon"></i>
                    <span id="btnText">Preview Data Agent</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Manual Input Tab Content -->
    <div id="manualTabContent" class="hidden space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center">
                    <i class="ti ti-user-plus text-brand-600 text-base"></i>
                </div>
                <h2 class="text-sm font-semibold text-slate-800">Registrasi Agent Baru Secara Manual</h2>
            </div>

            <form action="{{ route('exportregister.storeManual') }}" method="POST" id="manualForm" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama -->
                    <div>
                        <label class="block mb-2 text-xs font-semibold text-slate-700">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap agent" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-50 focus:border-brand-600 outline-none transition duration-150">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-2 text-xs font-semibold text-slate-700">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="agent@email.com" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-50 focus:border-brand-600 outline-none transition duration-150">
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label class="block mb-2 text-xs font-semibold text-slate-700">
                            Nomor WhatsApp
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-50 focus:border-brand-600 outline-none transition duration-150">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block mb-2 text-xs font-semibold text-slate-700">
                            Status Agent
                        </label>
                        <select name="status" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-50 focus:border-brand-600 outline-none transition duration-150 bg-white">
                            <option value="">-- Pilih Status --</option>
                            <option value="mahasiswa" {{ old('status') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="alumni" {{ old('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="orang_tua" {{ old('status') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="dosen_karyawan" {{ old('status') == 'dosen_karyawan' ? 'selected' : '' }}>Dosen / Karyawan</option>
                            <option value="mitra" {{ old('status') == 'mitra' ? 'selected' : '' }}>Mitra</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-xs font-semibold text-slate-700">
                            Password Awal
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="manual_password" placeholder="Masukkan password" required
                                class="w-full px-4 py-2.5 pr-12 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-50 focus:border-brand-600 outline-none transition duration-150">
                            <button type="button" onclick="togglePasswordVisibility('manual_password', 'eyeIconManualPassword')"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg id="eyeIconManualPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" id="manualSubmitBtn"
                        class="w-full flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="ti ti-user-plus text-base" id="manualBtnIcon"></i>
                    <span id="manualBtnText">Daftarkan Agent Baru</span>
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         TAHAP 2 — Preview & Konfirmasi
    ══════════════════════════════════════════════════════════ --}}
    @else

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-4">
        {{-- Total --}}
        <div class="stat-card bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <i class="ti ti-users text-brand-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Data</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalRows }}</p>
            </div>
        </div>
        {{-- Valid --}}
        <div class="stat-card bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                <i class="ti ti-circle-check text-emerald-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Siap Didaftarkan</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $validRows }}</p>
            </div>
        </div>
        {{-- Invalid --}}
        <div class="stat-card bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                <i class="ti ti-alert-circle text-red-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Bermasalah / Dilewati</p>
                <p class="text-2xl font-bold text-red-500">{{ $invalidRows }}</p>
            </div>
        </div>
    </div>

    {{-- Progress Bar --}}
    @if($totalRows > 0)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-slate-600">Tingkat keberhasilan data</span>
            <span class="text-xs font-bold text-brand-600">{{ round(($validRows / $totalRows) * 100) }}%</span>
        </div>
        <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
            <div class="progress-bar h-full bg-gradient-to-r from-brand-400 to-brand-600 rounded-full"
                 style="width: {{ round(($validRows / $totalRows) * 100) }}%"></div>
        </div>
    </div>
    @endif

    {{-- Preview Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ti ti-table text-brand-600"></i>
                <h2 class="text-sm font-semibold text-slate-800">Preview Data Agent</h2>
            </div>
            <div class="flex items-center gap-2">
                {{-- Filter toggle buttons --}}
                <button onclick="filterRows('all')" id="filterAll"
                        class="filter-btn text-xs px-3 py-1.5 rounded-lg bg-brand-600 text-white font-medium transition-colors">
                    Semua
                </button>
                <button onclick="filterRows('valid')" id="filterValid"
                        class="filter-btn text-xs px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 font-medium transition-colors hover:bg-slate-200">
                    Valid
                </button>
                <button onclick="filterRows('invalid')" id="filterInvalid"
                        class="filter-btn text-xs px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 font-medium transition-colors hover:bg-slate-200">
                    Bermasalah
                </button>
            </div>
        </div>

        <div class="preview-table-wrap">
            <table class="w-full text-xs" id="previewTable">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium w-8">#</th>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium">Nama</th>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium">Email</th>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium">No. HP</th>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium">Password</th>
                        <th class="px-4 py-3 text-left text-slate-500 font-medium">Status Import</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($preview as $i => $row)
                    <tr class="hover:bg-slate-50 transition-colors row-item {{ $row['_valid'] ? 'row-valid' : 'row-invalid' }}">
                        <td class="px-4 py-3 text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">
                            {{ $row['name'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $row['email'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600 font-mono">
                            {{ $row['phone'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusLabels = [
                                    'mahasiswa'      => ['bg-blue-50',   'text-blue-600',   'Mahasiswa'],
                                    'alumni'         => ['bg-purple-50', 'text-purple-600', 'Alumni'],
                                    'orang_tua'      => ['bg-amber-50',  'text-amber-600',  'Orang Tua'],
                                    'dosen_karyawan' => ['bg-teal-50',   'text-teal-600',   'Dosen/Karyawan'],
                                    'mitra'          => ['bg-pink-50',   'text-pink-600',   'Mitra'],
                                ];
                                $s = strtolower(trim($row['status'] ?? ''));
                                $cls = $statusLabels[$s] ?? ['bg-slate-50', 'text-slate-500', $row['status'] ?? '-'];
                            @endphp
                            <span class="px-2 py-1 rounded-md text-xs font-medium {{ $cls[0] }} {{ $cls[1] }}">
                                {{ $cls[2] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-400 font-mono">
                            {{ !empty($row['password']) ? str_repeat('•', min(strlen($row['password']), 10)) : '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($row['_valid'])
                                <span class="inline-flex items-center gap-1 badge-valid text-xs font-medium px-2 py-1 rounded-md">
                                    <i class="ti ti-circle-check text-xs"></i> Siap
                                </span>
                            @else
                                <div class="flex flex-col gap-0.5">
                                    <span class="inline-flex items-center gap-1 badge-invalid text-xs font-medium px-2 py-1 rounded-md mb-1">
                                        <i class="ti ti-alert-circle text-xs"></i> Dilewati
                                    </span>
                                    @foreach($row['_errors'] as $err)
                                        <span class="text-xs text-red-500">• {{ $err }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Empty state --}}
        <div id="emptyFilter" class="hidden py-12 text-center text-sm text-slate-400">
            <i class="ti ti-mood-empty text-3xl mb-2 block"></i>
            Tidak ada data untuk filter ini.
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-3">
        {{-- Upload ulang --}}
        <a href="{{ route('exportregister.index') }}"
           class="flex items-center gap-2 text-sm border border-slate-200 text-slate-600 px-5 py-3 rounded-xl hover:bg-slate-50 transition-colors font-medium">
            <i class="ti ti-upload text-base"></i>
            Upload Ulang
        </a>

        @if($validRows > 0)
        {{-- Konfirmasi --}}
        <form action="{{ route('exportregister.confirm') }}" method="POST" class="flex-1" id="confirmForm">
            @csrf
            <button type="submit"
                    onclick="return confirmSubmit()"
                    class="w-full flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                <i class="ti ti-user-plus text-base"></i>
                Daftarkan {{ $validRows }} Agent Sekarang
            </button>
        </form>
        @else
        <div class="flex-1 flex items-center justify-center gap-2 bg-slate-100 text-slate-400 text-sm font-semibold py-3.5 rounded-xl cursor-not-allowed">
            <i class="ti ti-user-off text-base"></i>
            Tidak ada data valid untuk didaftarkan
        </div>
        @endif
    </div>

    @endif {{-- end preview --}}

</main>

<script>
    // ── Drag & Drop ──────────────────────────────────────────
    const dropzone  = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const submitBtn = document.getElementById('submitBtn');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileNameText    = document.getElementById('fileNameText');

    if (dropzone) {
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelected(files[0]);
            }
        });

        fileInput?.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                handleFileSelected(fileInput.files[0]);
            }
        });

        function handleFileSelected(file) {
            fileNameText.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
            fileNameDisplay.classList.add('flex');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        // Submit loading state
        document.getElementById('uploadForm')?.addEventListener('submit', function () {
            submitBtn.disabled = true;
            document.getElementById('btnIcon').className = 'ti ti-loader-2 animate-spin text-base';
            document.getElementById('btnText').textContent = 'Memproses...';
        });
    }

    // ── Filter Rows ──────────────────────────────────────────
    function filterRows(type) {
        const rows    = document.querySelectorAll('.row-item');
        const empty   = document.getElementById('emptyFilter');
        const btns    = document.querySelectorAll('.filter-btn');
        let visible   = 0;

        btns.forEach(btn => {
            btn.classList.remove('bg-brand-600', 'text-white');
            btn.classList.add('bg-slate-100', 'text-slate-600');
        });

        const activeId = type === 'all' ? 'filterAll' : type === 'valid' ? 'filterValid' : 'filterInvalid';
        const activeBtn = document.getElementById(activeId);
        if (activeBtn) {
            activeBtn.classList.remove('bg-slate-100', 'text-slate-600');
            activeBtn.classList.add('bg-brand-600', 'text-white');
        }

        rows.forEach(row => {
            const show = type === 'all'
                || (type === 'valid'   && row.classList.contains('row-valid'))
                || (type === 'invalid' && row.classList.contains('row-invalid'));

            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        if (empty) empty.classList.toggle('hidden', visible > 0);
    }

    // ── Confirm Dialog ───────────────────────────────────────
    function confirmSubmit() {
        return confirm('Yakin ingin mendaftarkan semua agent valid?\nProses ini tidak dapat dibatalkan.');
    }

    // ── Tab Switching ─────────────────────────────────────────
    function switchTab(tab) {
        const tabExcelBtn = document.getElementById('tabExcelBtn');
        const tabManualBtn = document.getElementById('tabManualBtn');
        const excelTabContent = document.getElementById('excelTabContent');
        const manualTabContent = document.getElementById('manualTabContent');

        if (!tabExcelBtn || !tabManualBtn || !excelTabContent || !manualTabContent) return;

        if (tab === 'excel') {
            tabExcelBtn.classList.remove('border-transparent', 'text-slate-500');
            tabExcelBtn.classList.add('border-brand-600', 'text-brand-600');

            tabManualBtn.classList.remove('border-brand-600', 'text-brand-600');
            tabManualBtn.classList.add('border-transparent', 'text-slate-500');

            excelTabContent.classList.remove('hidden');
            manualTabContent.classList.add('hidden');
        } else {
            tabManualBtn.classList.remove('border-transparent', 'text-slate-500');
            tabManualBtn.classList.add('border-brand-600', 'text-brand-600');

            tabExcelBtn.classList.remove('border-brand-600', 'text-brand-600');
            tabExcelBtn.classList.add('border-transparent', 'text-slate-500');

            manualTabContent.classList.remove('hidden');
            excelTabContent.classList.add('hidden');
        }
    }

    // ── Password Visibility Toggle ────────────────────────────
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }

    // ── Manual Form Submit Loader ─────────────────────────────
    document.getElementById('manualForm')?.addEventListener('submit', function () {
        const manualSubmitBtn = document.getElementById('manualSubmitBtn');
        if (!manualSubmitBtn) return;
        manualSubmitBtn.disabled = true;
        document.getElementById('manualBtnIcon').className = 'ti ti-loader-2 animate-spin text-base';
        document.getElementById('manualBtnText').textContent = 'Memproses...';
    });
</script>

@endsection
