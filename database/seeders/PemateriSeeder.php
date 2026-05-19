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
                'nama_lengkap' => 'Dr. Budi Santoso',
                'email'        => 'budi@example.com',
                'no_telp'      => '08123456789',
                'kompetensi'   => 'Ahli K3 Industri',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 2,
                'nama_lengkap' => 'Ir. Siti Aminah',
                'email'        => 'siti@example.com',
                'no_telp'      => '08987654321',
                'kompetensi'   => 'Spesialis Audit ISO',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}