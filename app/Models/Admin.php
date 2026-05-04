<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'user_id',
        'role',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Admin dimiliki oleh satu User */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /** Cek apakah admin adalah superadmin */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /** Cek apakah admin aktif */
    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
