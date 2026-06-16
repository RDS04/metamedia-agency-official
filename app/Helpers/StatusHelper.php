<?php

namespace App\Helpers;

class StatusHelper
{
    public static function formatStatus($status)
    {
        $statusMap = [
            'mahasiswa' => 'Mahasiswa',
            'alumni' => 'Alumni',
            'orang_tua' => 'Orang Tua',
            'dosen_karyawan' => 'Dosen/Karyawan',
            'mitra' => 'Instansi / Mitra',
        ];

        return $statusMap[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
}
