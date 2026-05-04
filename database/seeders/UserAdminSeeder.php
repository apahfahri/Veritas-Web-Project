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
        // ADMIN CABANG — jambi, lampung, jakarta
        // =========================================================
        $adminJambi = User::create([
            'name'     => 'Admin Cabang Jambi',
            'email'    => 'admin.jambi@katigaveritas.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'user_id' => $adminJambi->id,
            'role'    => 'admin',
            'status'  => 'aktif',
            'cabang'  => 'jambi',
        ]);

        $adminLampung = User::create([
            'name'     => 'Admin Cabang Lampung',
            'email'    => 'admin.lampung@katigaveritas.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'user_id' => $adminLampung->id,
            'role'    => 'admin',
            'status'  => 'aktif',
            'cabang'  => 'lampung',
        ]);

        $adminJakarta = User::create([
            'name'     => 'Admin Cabang Jakarta',
            'email'    => 'admin.jakarta@katigaveritas.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'user_id' => $adminJakarta->id,
            'role'    => 'admin',
            'status'  => 'aktif',
            'cabang'  => 'jakarta',
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
