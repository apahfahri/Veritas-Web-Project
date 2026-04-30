<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    public function run()
    {
        // =========================================================
        // SUPERADMIN — akses penuh termasuk data perusahaan web
        // =========================================================
        $superadmin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@katigaveritas.com',
            'password' => Hash::make('superadmin123'),
        ]);

        Admin::create([
            'user_id' => $superadmin->id,
            'role'    => 'superadmin',
            'status'  => 'aktif',
        ]);

        // =========================================================
        // ADMIN — kelola data operasional
        // =========================================================
        $admin = User::create([
            'name'     => 'Admin Operasional',
            'email'    => 'admin@katigaveritas.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'role'    => 'admin',
            'status'  => 'aktif',
        ]);

        // =========================================================
        // USER DEMO — klien biasa untuk testing
        // =========================================================
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
