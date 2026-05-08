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
        'nama',
        'deskripsi',
    ];

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'id_kategori', 'id_kategori');
    }
}
