<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 'verifikasi';

    protected $fillable = [
        'no_sertifikat',
        'sertifikat_no',
        'status',
        'catatan',
        'ip_address',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Verifikasi merujuk ke satu Sertifikat (nullable jika tidak ditemukan) */
    public function sertifikat()
    {
        return $this->belongsTo(Sertifikat::class, 'sertifikat_no', 'no_sertifikat');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /** Cek apakah sertifikat ditemukan dan valid */
    public function isValid(): bool
    {
        return $this->status === 'valid';
    }

    /** Label status dalam Bahasa Indonesia */
    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'valid'           => '✅ Sertifikat Valid',
            'tidak_valid'     => '❌ Sertifikat Tidak Valid',
            'tidak_ditemukan' => '⚠️ Sertifikat Tidak Ditemukan',
            default           => '-',
        };
    }
}
