<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /** User bisa menjadi Admin */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /** User bisa memiliki profil Klien Individu */
    public function klienIndividu()
    {
        return $this->hasOne(KlienIndividu::class);
    }

    /** User bisa memiliki profil Klien Perusahaan */
    public function klienPerusahaan()
    {
        return $this->hasOne(KlienPerusahaan::class);
    }

    /** User memiliki banyak Pendaftaran layanan */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /** Cek apakah user adalah admin (role apapun) */
    public function isAdmin(): bool
    {
        return $this->admin()->exists();
    }

    /** Cek apakah user adalah superadmin */
    public function isSuperAdmin(): bool
    {
        return $this->admin?->role === 'superadmin';
    }

    /** Cek apakah user adalah admin cabang */
    public function isBranchAdmin(): bool
    {
        return $this->admin?->role === 'admin' && !empty($this->admin?->cabang);
    }

    /** Mendapatkan nama cabang dari admin cabang */
    public function adminCabang(): ?string
    {
        return $this->admin?->cabang;
    }

    /** Cek apakah user adalah klien individu */
    public function isIndividu(): bool
    {
        return $this->klienIndividu()->exists();
    }

    /** Cek apakah user adalah klien perusahaan */
    public function isPerusahaan(): bool
    {
        return $this->klienPerusahaan()->exists();
    }
}
