<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'klien_perusahaan';

    protected $fillable = [
        'user_id',
        'perusahaan_id',
        'nama_lengkap',
        'jabatan',
        'no_hp',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Profil klien perusahaan dimiliki oleh satu User */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Klien perusahaan terhubung ke satu Perusahaan */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
