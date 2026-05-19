<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLayanan extends Model
{
    use HasFactory;

    protected $table = 'kategori_layanan';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'kode_kategori',
        'nama',
        'deskripsi',
    ];

    public function jenis()
    {
        return $this->hasMany(JenisLayanan::class, 'id_kategori', 'id_kategori');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_kategori', 'id_kategori');
    }
}
