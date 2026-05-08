<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriLayananSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_layanan')->insert([
            [
                'nama' => 'Pelatihan K3',
                'deskripsi' => 'Pelatihan Keselamatan dan Kesehatan Kerja untuk berbagai sektor industri.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Konsultasi SMK3',
                'deskripsi' => 'Konsultasi Sistem Manajemen Keselamatan dan Kesehatan Kerja.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Audit K3',
                'deskripsi' => 'Audit kepatuhan dan implementasi K3 di perusahaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
