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
                'nama_lengkap' => 'Ir. Hendro Supriadi, M.KKK',
                'email' => 'hendro@veritas.com',
                'no_hp' => '081234567801',
                'kompetensi' => 'Ahli K3 Umum Spesialisasi Manufaktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'dr. Anita Larasati, Sp.Ok',
                'email' => 'anita@veritas.com',
                'no_hp' => '081234567802',
                'kompetensi' => 'Dokter Kesehatan Kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
