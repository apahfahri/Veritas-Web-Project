<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    public function run()
    {
        DB::table('perusahaan')->insert([
            [
                'nama' => 'PT Makmur Jaya',
                'alamat' => 'Jl. Industri No. 1, Jakarta',
                'sektor_industri' => 'Manufaktur',
                'jumlah_karyawan' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Sumber Rejeki',
                'alamat' => 'Jl. Perdagangan No. 10, Bandung',
                'sektor_industri' => 'Perdagangan',
                'jumlah_karyawan' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
