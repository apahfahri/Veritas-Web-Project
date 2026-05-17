<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';

    protected $fillable = [
        'layanan_id',
        'petugas_id',
        'jenis_pertemuan',
        'jam_pertemuan',
        'tanggal_usul',
        'topik',
    ];

    protected $casts = [
        'tanggal_usul' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Konsultasi merupakan detail dari satu Layanan */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /** Konsultasi ditangani oleh satu Petugas */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
