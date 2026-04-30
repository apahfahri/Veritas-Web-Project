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
        'materi',
        'jenis_pertemuan',
        'jam_pertemuan',
        'tanggal_pertemuan',
        'lokasi',
        'kapasitas',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
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
}
