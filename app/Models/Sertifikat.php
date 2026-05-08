<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $primaryKey = 'no_sertifikat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_sertifikat',
        'id_pendaftaran',
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
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    /** Sertifikat dapat diverifikasi berkali-kali */
    public function verifikasi()
    {
        return $this->hasMany(Verifikasi::class, 'sertifikat_no', 'no_sertifikat');
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
