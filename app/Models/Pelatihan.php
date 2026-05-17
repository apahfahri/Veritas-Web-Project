<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';

    protected $fillable = [
        'layanan_id',
        'petugas_id',
        'materi',
        'jenis_pertemuan',
        'jam_pertemuan',
        'tanggal_usul',
        'lokasi',
        'kapasitas',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_usul' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Pelatihan merupakan detail dari satu Layanan */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /** Pelatihan ditangani oleh satu Petugas */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
