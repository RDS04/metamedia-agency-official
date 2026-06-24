<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'rating',
        'fitur_favorit',
        'saran',
        'rekomendasi',
        'tampil',
    ];

    protected $casts = [
        'fitur_favorit' => 'array',
        'tampil'        => 'boolean',
        'rating'        => 'integer',
    ];

    /**
     * Scope: hanya yang di-set tampil = true
     */
    public function scopeTampil($query)
    {
        return $query->where('tampil', true);
    }

    /**
     * Inisial dua huruf dari nama lengkap
     */
    public function getInisialAttribute(): string
    {
        $parts = explode(' ', trim($this->nama_lengkap));
        $inisial = strtoupper(substr($parts[0], 0, 1));
        if (isset($parts[1])) {
            $inisial .= strtoupper(substr($parts[1], 0, 1));
        }
        return $inisial;
    }
}
