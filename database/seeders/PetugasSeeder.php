<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        $petugas = [
            [
                'nama_lengkap' => 'Dr. Ahmad Fauzi, S.K3',
                'email'        => 'ahmad.fauzi@katigaveritas.com',
                'no_hp'        => '081234567001',
                'spesialisasi' => 'Keselamatan Kerja & SMK3',
            ],
            [
                'nama_lengkap' => 'Ir. Dewi Lestari, M.T.',
                'email'        => 'dewi.lestari@katigaveritas.com',
                'no_hp'        => '081234567002',
                'spesialisasi' => 'Higiene Industri & Kesehatan Kerja',
            ],
            [
                'nama_lengkap' => 'Rudi Hermawan, S.T.',
                'email'        => 'rudi.hermawan@katigaveritas.com',
                'no_hp'        => '081234567003',
                'spesialisasi' => 'Audit K3 & ISO 45001',
            ],
            [
                'nama_lengkap' => 'Sari Indah Permata, S.K.M.',
                'email'        => 'sari.indah@katigaveritas.com',
                'no_hp'        => '081234567004',
                'spesialisasi' => 'Pelatihan K3 & Sertifikasi',
            ],
        ];

        foreach ($petugas as $data) {
            Petugas::create($data);
        }
    }
}
