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
        'file_pdf',
        'penerbit',
        'masa_berlaku',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'masa_berlaku'   => 'date',
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

    /** Ambil URL file PDF sertifikat */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->file_pdf ? asset('storage/' . $this->file_pdf) : null;
    }
}
