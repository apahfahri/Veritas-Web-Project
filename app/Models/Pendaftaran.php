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
        'status_progres',
        'status_bayar',
        'cabang',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'is_utusan_perusahaan' => 'boolean',
    ];

    /**
     * Scope a query to only include records from the subadmin's branch.
     */
    protected static function booted()
    {
        static::addGlobalScope('cabang', function (Builder $builder) {
            if (Auth::check() && Auth::user()->isSubadmin()) {
                $cabang = Auth::user()->admin?->cabang;
                if ($cabang) {
                    $builder->where('pendaftaran.cabang', $cabang);
                }
            }
        });
    }

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
}
