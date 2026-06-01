<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'id_materi';
    protected $fillable = ['judul', 'file_path', 'deskripsi'];

    public function jadwals()
    {
        return $this->belongsToMany(Jadwal::class, 'jadwal_materi', 'id_materi', 'id_jadwal');
    }
}
