<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';

    protected $fillable = [
        'nama',
        'alamat',
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
        return $this->hasMany(KlienPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'id_perusahaan', 'id_perusahaan');
    }
}
