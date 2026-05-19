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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_pendaftaran)) {
                $jadwal = Jadwal::with(['kategori', 'jenis'])->find($model->id_jadwal);

                $kategoriKode = $jadwal?->kategori?->kode_kategori ?? 'XXX';
                $jenisKode    = $jadwal?->jenis?->kode_jenis ?? ($jadwal?->kode_jadwal ?? 'XXX');

                $mode = match($model->mode_pertemuan) {
                    'offline' => 'OFF',
                    'hybrid'  => 'HYB',
                    default   => 'ON',
                };

                $date = $model->tanggal_daftar
                    ? \Carbon\Carbon::parse($model->tanggal_daftar)->format('dmY')
                    : now()->format('dmY');

                $countToday = static::whereDate('tanggal_daftar', $model->tanggal_daftar ?? now())->count();
                $seq = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);

                $model->nomor_pendaftaran = strtoupper("{$kategoriKode}-{$jenisKode}-{$mode}-{$date}-{$seq}");
            }
        });
    }

    protected $fillable = [
        'nomor_pendaftaran',
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
        'is_utusan_perusahaan'    => 'boolean',
        'last_reminder_sent_at'   => 'datetime',
    ];

    /* ─── RELASI ─────────────────────────────────────────────── */

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

    /* ─── HELPERS ────────────────────────────────────────────── */

    public function getNamaProgramAttribute(): string
    {
        return $this->jadwal?->jenis?->nama ?? '—';
    }

    public function getNoRegistrasiAttribute(): string
    {
        $year = $this->tanggal_daftar?->format('Y') ?? ($this->created_at?->format('Y') ?? date('Y'));
        return 'REG-' . $year . '-' . sprintf('%04d', $this->id_pendaftaran);
    }
}
