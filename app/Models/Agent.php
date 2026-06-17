<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    protected $table = "camabas";
   protected $fillable = [
        'agent_id',
        'nama_lengkap',
        'nik',
        'nomor_hp',
        'jenis_kelamin',
        'program_studi',
        'sistem_kuliah',
        'periode',
        'status',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
