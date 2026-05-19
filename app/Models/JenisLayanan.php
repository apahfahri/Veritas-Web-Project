<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan';
    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'id_kategori',
        'nama',
        'kode_jenis',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLayanan::class, 'id_kategori', 'id_kategori');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_jenis', 'id_jenis');
    }
}
