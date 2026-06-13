@extends('auth.layout.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total User -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-[#018FD7]">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-gray-500 text-sm">
                    Total User
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    1.250
                </h2>
            </div>

            <div class="text-4xl">
                👥
            </div>

        </div>

    </div>

    <!-- Mahasiswa -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-green-500">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-gray-500 text-sm">
                    Mahasiswa
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    850
                </h2>
            </div>

            <div class="text-4xl">
                🎓
            </div>

        </div>

    </div>

    <!-- Alumni -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-yellow-500">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-gray-500 text-sm">
                    Alumni
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    280
                </h2>
            </div>

            <div class="text-4xl">
                🏆
            </div>

        </div>

    </div>

    <!-- Referral -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-red-500">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-gray-500 text-sm">
                    Referral
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    120
                </h2>
            </div>

            <div class="text-4xl">
                🔗
            </div>

        </div>

    </div>

</div>

<!-- Grafik dan Aktivitas -->
<div class="grid lg:grid-cols-3 gap-6 mt-6">

    <!-- Grafik -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">

        <div class="flex justify-between mb-4">

            <h2 class="font-bold text-lg">
                Statistik Pendaftaran
            </h2>

            <span class="text-sm text-gray-500">
                Tahun 2026
            </span>

        </div>

        <canvas id="registrationChart" height="100"></canvas>

    </div>

    <!-- Ringkasan -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="font-bold text-lg mb-5">
            Ringkasan
        </h2>

        <div class="space-y-5">

            <div>
                <div class="flex justify-between">
                    <span>Pendaftar</span>
                    <span class="font-bold">850</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-[#018FD7] h-2 rounded-full w-[85%]"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between">
                    <span>Diterima</span>
                    <span class="font-bold">700</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-500 h-2 rounded-full w-[70%]"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between">
                    <span>Registrasi Ulang</span>
                    <span class="font-bold">620</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-yellow-500 h-2 rounded-full w-[62%]"></div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Tabel -->
<div class="bg-white rounded-2xl shadow-sm mt-6">

    <div class="p-6 border-b">

        <h2 class="font-bold text-lg">
            Pendaftaran Terbaru
        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">No HP</th>
                    <th class="p-4 text-left">Tanggal</th>

                </tr>

            </thead>

            <tbody>

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4">Andi Saputra</td>

                    <td class="p-4">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            Mahasiswa
                        </span>
                    </td>

                    <td class="p-4">081234567890</td>

                    <td class="p-4">13 Juni 2026</td>

                </tr>

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4">Budi Santoso</td>

                    <td class="p-4">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                            Alumni
                        </span>
                    </td>

                    <td class="p-4">081234567891</td>

                    <td class="p-4">12 Juni 2026</td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('registrationChart'), {

    type: 'line',

    data: {

        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun'
        ],

        datasets: [{

            label: 'Pendaftaran',

            data: [
                50,
                120,
                180,
                250,
                350,
                450
            ],

            borderColor: '#018FD7',

            backgroundColor: 'rgba(1,143,215,0.1)',

            fill: true,

            tension: 0.4

        }]

    }

});

</script>

@endpush