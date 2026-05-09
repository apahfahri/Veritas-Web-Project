<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'pendidikan',
        'no_telp',
        'email',
        'password',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_user', 'id_user');
    }

    public function klien()
    {
        return $this->hasOne(KlienIndividu::class, 'user_id', 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user', 'id_user');
    }

    public function isAdmin()
    {
        return $this->admin()->where('role', 'admin')->exists();
    }

    public function isSubadmin()
    {
        return $this->admin()->where('role', 'subadmin')->exists();
    }
}
