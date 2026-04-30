<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'nama',
        'alamat',
        'nib_oss',
        'npwp_perusahaan',
        'sektor_industri',
        'jumlah_karyawan',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Satu perusahaan memiliki banyak klien perusahaan (karyawan/perwakilan) */
    public function klienPerusahaan()
    {
        return $this->hasMany(KlienPerusahaan::class);
    }
}
