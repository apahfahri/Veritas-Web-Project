<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_layanan',
        'id_jadwal',
        'id_admin',
        'id_user',
        'is_utusan_perusahaan',
        'id_perusahaan',
        'tanggal_daftar',
        'rencana_tanggal_mulai',
        'rencana_tanggal_selesai',
        'mode_pertemuan',
        'status_progres',
        'status_bayar',
        'bukti_bayar',
        'cabang',
        'last_reminder_details',
        'last_reminder_sent_at',
    ];

    protected $casts = [
        'tanggal_daftar'          => 'date',
        'rencana_tanggal_mulai'   => 'date',
        'rencana_tanggal_selesai' => 'date',
        'last_reminder_sent_at'   => 'datetime',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    /**
     * Get dynamic cancellation reason based on registration ID.
     */
    public function getAlasanBatalAttribute()
    {
        $reasons = [
            'Batas waktu pembayaran kedaluwarsa (sistem otomatis)',
            'Permintaan pembatalan mandiri oleh Klien/Mitra',
            'Jadwal kelas pelatihan penuh / kuota tidak mencukupi',
            'Kesalahan pemilihan metode/jadwal oleh pendaftar'
        ];
        return $reasons[$this->id_pendaftaran % count($reasons)];
    }

    /**
     * Get formatted registration number / invoice.
     */
    public function getNoRegistrasiAttribute()
    {
        $year = $this->tanggal_daftar ? $this->tanggal_daftar->format('Y') : ($this->created_at ? $this->created_at->format('Y') : date('Y'));
        return 'REG-' . $year . '-' . sprintf('%04d', $this->id_pendaftaran);
    }
}
