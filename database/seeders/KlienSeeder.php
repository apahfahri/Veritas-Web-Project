<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\KlienIndividu;
use App\Models\KlienPerusahaan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KlienSeeder extends Seeder
{
    public function run()
    {
        // 1. Klien Individu
        $user1 = User::create([
            'username' => 'Ahmad Zulkarnaen',
            'email'    => 'ahmad.z@example.com',
            'password' => Hash::make('password123'),
        ]);

        KlienIndividu::create([
            'user_id'      => $user1->id,
            'nik'          => '3201234567890001',
            'nama_lengkap' => 'Ahmad Zulkarnaen, S.T.',
            'no_hp'        => '081299990001',
        ]);

        $user2 = User::create([
            'username' => 'Linda Permata',
            'email'    => 'linda.p@example.com',
            'password' => Hash::make('password123'),
        ]);

        KlienIndividu::create([
            'user_id'      => $user2->id,
            'nik'          => '3201234567890002',
            'nama_lengkap' => 'Linda Permata, S.K.M.',
            'no_hp'        => '081299990002',
        ]);

        // 2. Klien Perusahaan (PIC)
        $ptAdhi = Perusahaan::where('nama', 'LIKE', '%Adhi Karya%')->first();
        $userPic1 = User::create([
            'username' => 'Herry Kusuma',
            'email'    => 'herry.k@adhikarya.com',
            'password' => Hash::make('password123'),
        ]);

        KlienPerusahaan::create([
            'user_id'       => $userPic1->id,
            'perusahaan_id' => $ptAdhi->id,
            'nama_lengkap'  => 'Herry Kusuma',
            'jabatan'       => 'HSE Manager',
        ]);

        $ptPertamina = Perusahaan::where('nama', 'LIKE', '%Pertamina%')->first();
        $userPic2 = User::create([
            'username' => 'Ratna Sari',
            'email'    => 'ratna.s@pertamina.com',
            'password' => Hash::make('password123'),
        ]);

        KlienPerusahaan::create([
            'user_id'       => $userPic2->id,
            'perusahaan_id' => $ptPertamina->id,
            'nama_lengkap'  => 'Ratna Sari',
            'jabatan'       => 'Safety Officer',
        ]);
        
        // Link existing demo users from UserAdminSeeder (if they exist)
        $budi = User::where('email', 'budi@example.com')->first();
        if ($budi && !KlienIndividu::where('user_id', $budi->id)->exists()) {
            KlienIndividu::create([
                'user_id'      => $budi->id,
                'nik'          => '3201234567891001',
                'nama_lengkap' => 'Budi Santoso',
                'no_hp'        => '081288880001',
            ]);
        }

        $siti = User::where('email', 'siti@example.com')->first();
        if ($siti && !KlienIndividu::where('user_id', $siti->id)->exists()) {
            KlienIndividu::create([
                'user_id'      => $siti->id,
                'nik'          => '3201234567891002',
                'nama_lengkap' => 'Siti Rahayu',
                'no_hp'        => '081288880002',
            ]);
        }
    }
}
