<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    // Program Studi yang valid
    const PROGRAM_STUDI = [
        'Sistem Informasi',
        'Informatika',
        'Bisnis Digital',
        'Desain Komunikasi Visual',
        'Pendidikan Teknologi Informasi',
        'Manajemen Ritel'
    ];

    protected $table = 'mahasiswas';
    
    protected $fillable = [
        'nik',
        'no_pendaftaran',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'program_studi',
        'sistem_kuliah',
        'periode'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}