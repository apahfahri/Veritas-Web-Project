<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'klien_perusahaan';
    protected $primaryKey = 'id_k_perusahaan';

    protected $fillable = [
        'id_user',
        'id_perusahaan',
        'jabatan',
        'nama_cp',
        'no_hp_cp',
        'catatan',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Profil klien perusahaan dimiliki oleh satu User */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /** Klien perusahaan terhubung ke satu Perusahaan */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Ambil nama CP aktif: dari relasi User (jika terdaftar), atau nama_cp manual.
     */
    public function getNamaCpAktifAttribute(): string
    {
        return $this->user?->nama ?? $this->nama_cp ?? '—';
    }
}
