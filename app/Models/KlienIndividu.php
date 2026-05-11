<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class KlienIndividu extends Model
{
    use HasFactory;

    protected $table = 'klien_individu';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'no_hp',
        'id_perusahaan',
        'jabatan',
        'cabang',
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
                    $builder->where('klien_individu.cabang', $cabang);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
