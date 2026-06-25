<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exportregis extends Model
{
    protected $table = 'exportregis';

    protected $fillable = [
        'batch_id',
        'name',
        'email',
        'phone',
        'status',
        'password',
        'status_import',
        'pesan',
    ];
}
