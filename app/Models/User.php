<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

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
}
