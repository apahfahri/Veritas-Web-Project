<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_layanan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'kuota',
        'cabang',
        'status',
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
                    $builder->where('jadwal.cabang', $cabang);
                }
            }
        });
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'id_jadwal', 'id_jadwal');
    }
}
