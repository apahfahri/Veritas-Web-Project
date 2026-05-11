<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'username' => 'superadmin',
            'email' => 'superadmin@veritas.com',
            'password' => Hash::make('password123'),
            'no_telp' => '081234567890',
            'role' => 'superadmin',
            'status' => 'aktif',
        ]);

        Admin::create([
            'username' => 'subadmin_1',
            'email' => 'subadmin1@veritas.com',
            'password' => Hash::make('password123'),
            'no_telp' => '081234567891',
            'role' => 'subadmin',
            'status' => 'aktif',
            'cabang' => 'Bandung',
        ]);
        
        Admin::create([
            'username' => 'subadmin_2',
            'email' => 'subadmin2@veritas.com',
            'password' => Hash::make('password123'),
            'no_telp' => '081234567892',
            'role' => 'subadmin',
            'status' => 'aktif',
            'cabang' => 'Jakarta',
        ]);
    }
}
