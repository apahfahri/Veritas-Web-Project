<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'layanan_id',
        'user_id',
        'tanggal_daftar',
        'status_progres',
        'status_bayar',
        'cabang',
        'dokumen_lengkap',
        'last_reminder_sent_at',
        'last_reminder_details',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'last_reminder_sent_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Pendaftaran dilakukan oleh satu User */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Pendaftaran untuk satu Layanan */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /** Pendaftaran menghasilkan satu Sertifikat */
    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /** Cek apakah pendaftaran sudah selesai */
    public function isSelesai(): bool
    {
        return $this->status_progres === 'selesai';
    }

    /** Cek apakah pembayaran sudah lunas */
    public function isLunas(): bool
    {
        return $this->status_bayar === 'lunas';
    }
}
