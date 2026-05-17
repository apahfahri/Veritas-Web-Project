<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';

    protected $fillable = [
        'id_kategori',
        'nama',
        'materi',
        'jenis_pertemuan',
        'tanggal_usul',
        'tgl_mulai',
        'tgl_selesai',
        'jam_pertemuan',
        'lokasi',
        'kapasitas',
        'harga',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_usul' => 'date',
        'tgl_mulai'         => 'date',
        'tgl_selesai'       => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLayanan::class, 'id_kategori', 'id_kategori');
    }

    public function pemateri()
    {
        return $this->belongsToMany(Pemateri::class, 'layanan_pemateri', 'id_layanan', 'id_pemateri');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_layanan', 'id_layanan');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_layanan', 'id_layanan');
    }
}
