<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Jadwal — menggantikan tabel `layanan` sebelumnya.
 * Setiap baris merepresentasikan satu sesi/jadwal pelaksanaan program layanan.
 */
class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_kategori',
        'id_jenis',
        'kode_jadwal',
        'jenis_pertemuan',
        'tgl_mulai',
        'tgl_selesai',
        'jam_pertemuan',
        'lokasi',
        'kapasitas',
        'harga',
        'deskripsi',
        'file_rundown',
        'link_meet',
        'reminder_h3_sent_at',
    ];

    protected $casts = [
        'tgl_mulai'    => 'date',
        'tgl_selesai'  => 'date',
    ];

    /* ─── RELASI ─────────────────────────────────────────────── */

    public function kategori()
    {
        return $this->belongsTo(KategoriLayanan::class, 'id_kategori', 'id_kategori');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisLayanan::class, 'id_jenis', 'id_jenis');
    }

    public function pemateri()
    {
        return $this->belongsToMany(Pemateri::class, 'jadwal_pemateri', 'id_jadwal', 'id_pemateri');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'id_jadwal', 'id_jadwal');
    }

    public function materi()
    {
        return $this->belongsToMany(Materi::class, 'jadwal_materi', 'id_jadwal', 'id_materi');
    }

    /* ─── HELPERS ────────────────────────────────────────────── */

    /**
     * Mendapatkan nama program dari relasi jenis layanan.
     */
    public function getNamaProgramAttribute(): string
    {
        return $this->jenis?->nama ?? '—';
    }

    /**
     * Hitung sisa kursi berdasarkan pendaftaran yang terkonfirmasi & lunas.
     */
    public function getSisaKursiAttribute(): ?int
    {
        if (!$this->kapasitas) return null;

        $terdaftar = $this->pendaftarans()
            ->whereIn('status_progres', ['diproses', 'selesai'])
            ->where('status_bayar', 'lunas')
            ->count();

        return max(0, $this->kapasitas - $terdaftar);
    }
}
