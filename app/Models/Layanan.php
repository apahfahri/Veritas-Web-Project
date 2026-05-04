<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Layanan memiliki satu detail Pelatihan */
    public function pelatihan()
    {
        return $this->hasOne(Pelatihan::class);
    }

    /** Layanan memiliki satu detail Konsultasi */
    public function konsultasi()
    {
        return $this->hasOne(Konsultasi::class);
    }

    /** Layanan memiliki satu detail Audit */
    public function audit()
    {
        return $this->hasOne(Audit::class);
    }

    /** Layanan memiliki banyak Pendaftaran */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
