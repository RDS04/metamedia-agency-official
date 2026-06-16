<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = "camabas";
   protected $fillable = [
        'nama_lengkap',
        'nik',
        'nomor_hp',
        'jenis_kelamin',
        'program_studi',
        'sistem_kuliah',
        'periode'
    ];
}
