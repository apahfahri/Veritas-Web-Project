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

    public function klienPerusahaan()
    {
        return $this->hasOne(KlienPerusahaan::class, 'user_id', 'id_user');
    }
}
