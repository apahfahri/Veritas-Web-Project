<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemateriSeeder extends Seeder
{
    public function run()
    {
        DB::table('pemateri')->insert([
            [
                'id_pemateri'  => 1,
                'nama_lengkap' => 'Dr. Budi Santoso, M.K.K.K.',
                'email'        => 'budi@example.com',
                'no_telp'      => '081234567890',
                'kompetensi'   => 'Ahli K3 Industri & Auditor SMK3',
                'foto'         => 'pemateri/man_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 2,
                'nama_lengkap' => 'Ir. Siti Aminah, S.T., M.T.',
                'email'        => 'siti@example.com',
                'no_telp'      => '089876543210',
                'kompetensi'   => 'Spesialis Audit ISO & Higiene Industri',
                'foto'         => 'pemateri/woman_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 3,
                'nama_lengkap' => 'Bambang Irawan, S.KM.',
                'email'        => 'bambang@example.com',
                'no_telp'      => '081122334455',
                'kompetensi'   => 'Instruktur P3K & Keselamatan Kebakaran',
                'foto'         => 'pemateri/man_2.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 4,
                'nama_lengkap' => 'dr. Andika Putra, Sp.Ok.',
                'email'        => 'andika@example.com',
                'no_telp'      => '082233445566',
                'kompetensi'   => 'Kesehatan Kerja & K3 Fasyankes',
                'foto'         => 'pemateri/man_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 5,
                'nama_lengkap' => 'Agus Setiawan, S.T.',
                'email'        => 'agus@example.com',
                'no_telp'      => '083344556677',
                'kompetensi'   => 'Ahli K3 Konstruksi & Perancah',
                'foto'         => 'pemateri/man_2.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 6,
                'nama_lengkap' => 'Diana Lestari, S.Si.',
                'email'        => 'diana@example.com',
                'no_telp'      => '084455667788',
                'kompetensi'   => 'Ahli K3 Kimia & Pengendalian Lingkungan',
                'foto'         => 'pemateri/woman_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 7,
                'nama_lengkap' => 'Hendra Saputra, M.Eng.',
                'email'        => 'hendra@example.com',
                'no_telp'      => '085566778899',
                'kompetensi'   => 'Ahli K3 Listrik & Mekanik',
                'foto'         => 'pemateri/man_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 8,
                'nama_lengkap' => 'Reza Pratama, S.T., M.Sc.',
                'email'        => 'reza@example.com',
                'no_telp'      => '086677889900',
                'kompetensi'   => 'Ahli K3 Migas & Confined Space',
                'foto'         => 'pemateri/man_2.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 9,
                'nama_lengkap' => 'Nurul Huda, S.K.M., M.Epid.',
                'email'        => 'nurul@example.com',
                'no_telp'      => '087788990011',
                'kompetensi'   => 'Higiene Industri & Ergonomi Kerja',
                'foto'         => 'pemateri/woman_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 10,
                'nama_lengkap' => 'Wira Kesuma, S.T.',
                'email'        => 'wira@example.com',
                'no_telp'      => '088899001122',
                'kompetensi'   => 'Instruktur Operator Angkat Angkut',
                'foto'         => 'pemateri/man_1.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ]);
    }
}
