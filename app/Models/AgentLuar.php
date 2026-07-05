<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgentLuar extends Authenticatable
{
    use Notifiable;

    protected $table = 'agent_luars';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',     
        'kode_referral_dipakai',
        'agent_internal_id',
        'kode_referral',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Agent Internal (User) yang merekrut agent luar ini.
     */
    public function agentInternal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_internal_id');
    }

    /**
     * Daftar camaba yang direkrut oleh agent luar ini.
     */
    public function camabas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Agent::class, 'agent_luar_id');
    }
}
