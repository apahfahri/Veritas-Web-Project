<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPelatihan extends Model
{
    use HasFactory;

    protected $table = 'request_pelatihan';
    protected $primaryKey = 'id_request';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telp',
        'nama_perusahaan',
        'jabatan',
        'alamat_perusahaan',
        'sektor_industri',
        'jumlah_karyawan',
        'topik_pelatihan',
        'tanggal_harapan',
        'pesan_tambahan',
        'status',
    ];
}
