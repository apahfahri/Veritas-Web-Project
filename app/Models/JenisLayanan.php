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
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLayanan::class, 'id_kategori', 'id_kategori');
    }
}
