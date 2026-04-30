<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_hp',
        'spesialisasi',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Petugas menangani banyak Pendaftaran */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
