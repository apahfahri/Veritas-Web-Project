<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'no_sertifikat',
        'pendaftaran_id',
        'nama_lengkap',
        'tanggal_terbit',
        'file',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Sertifikat diterbitkan dari satu Pendaftaran */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    /** Sertifikat dapat diverifikasi berkali-kali */
    public function verifikasi()
    {
        return $this->hasMany(Verifikasi::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /** Ambil URL file sertifikat */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? asset('storage/' . $this->file) : null;
    }
}
