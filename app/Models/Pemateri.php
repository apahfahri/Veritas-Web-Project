<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemateri extends Model
{
    use HasFactory;

    protected $table = 'pemateri';
    protected $primaryKey = 'id_pemateri';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_hp',
        'kompetensi',
        'foto',
        'bio',
    ];

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'layanan_pemateri', 'id_pemateri', 'id_layanan');
    }
}
