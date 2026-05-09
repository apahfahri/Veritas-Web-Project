<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_layanan',
        'id_admin',
        'id_user',
        'tanggal_daftar',
        'rencana_tanggal_mulai',
        'rencana_tanggal_selesai',
        'mode_pertemuan',
        'status_progres',
        'status_bayar',
    ];

    protected $casts = [
        'tanggal_daftar'          => 'date',
        'rencana_tanggal_mulai'   => 'date',
        'rencana_tanggal_selesai' => 'date',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
