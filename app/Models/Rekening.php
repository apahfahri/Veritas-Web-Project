<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekenings';
    protected $primaryKey = 'id_rekening';

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];
}
