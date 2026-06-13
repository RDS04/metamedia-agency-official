<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = "mahasiswas";
    protected $fillable = [
        'name',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'asal_sekolah',
        'tahun_lulus',
        'program_studi',
        'kelas',
    ];
}
