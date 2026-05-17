<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';

    protected $fillable = [
        'layanan_id',
        'petugas_id',
        'lingkup',
        'jam_pertemuan',
        'tanggal_usul',
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

    /** Audit merupakan detail dari satu Layanan */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /** Audit ditangani oleh satu Petugas */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
