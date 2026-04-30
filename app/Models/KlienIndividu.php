<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienIndividu extends Model
{
    use HasFactory;

    protected $table = 'klien_individu';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'no_hp',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** Profil individu dimiliki oleh satu User */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
