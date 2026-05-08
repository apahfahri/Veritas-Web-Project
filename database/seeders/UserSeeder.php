<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Budi Santoso',
            'pendidikan' => 'S1 Teknik Industri',
            'no_telp' => '081234560001',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'nama' => 'Andi Wijaya',
            'pendidikan' => 'D3 K3',
            'no_telp' => '081234560002',
            'email' => 'andi@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
