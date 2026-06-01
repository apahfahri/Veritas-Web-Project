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
                $jenisKode    = $jadwal?->jenis?->kode_jenis ?? 'XXX';

                // Ambil nomor urut jadwal dari kode_jadwal (misal: PLT-AK3U-02 → 02)
                $kodeJadwal = $jadwal?->kode_jadwal ?? '';
                $parts      = array_filter(explode('-', $kodeJadwal));
                $jadwalSeq  = count($parts) >= 3 ? end($parts) : '00';

                $mode = match($model->mode_pertemuan) {
                    'offline' => 'OFF',
                    'hybrid'  => 'HYB',
                    default   => 'ON',
                };

                $tglMulai = $jadwal?->tgl_mulai ?? $model->rencana_tanggal_mulai ?? $model->tanggal_daftar ?? now();
                $date = \Carbon\Carbon::parse($tglMulai)->format('dmY');

                $countProgram = static::where('id_jadwal', $model->id_jadwal)->count();
                $seq = str_pad($countProgram + 1, 4, '0', STR_PAD_LEFT);

                $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $uniqueCode = '';
                for ($i = 0; $i < 5; $i++) {
                    $uniqueCode .= $chars[rand(0, strlen($chars) - 1)];
                }

                $model->nomor_pendaftaran = strtoupper("{$uniqueCode}-{$kategoriKode}-{$jenisKode}-{$jadwalSeq}-{$mode}-{$date}-{$seq}");
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
        'is_kustom',
        'catatan_klien',
        'tanggal_daftar',
        'rencana_tanggal_mulai',
        'rencana_tanggal_selesai',
        'mode_pertemuan',
        'status_progres',
        'status_bayar',
        'bukti_bayar',
        'last_reminder_details',
        'last_reminder_sent_at',
    ];

    protected $casts = [
        'tanggal_daftar'          => 'date',
        'rencana_tanggal_mulai'   => 'date',
        'rencana_tanggal_selesai' => 'date',
        'is_utusan_perusahaan'    => 'boolean',
        'is_kustom'               => 'boolean',
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
