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
        'jenis_pertemuan',
        'jam_pertemuan',
        'tanggal_pertemuan',
        'topik',
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
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
}
