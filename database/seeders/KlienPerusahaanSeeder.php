<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlienPerusahaanSeeder extends Seeder
{
    public function run()
    {
        // Asumsi user_id 1 dan perusahaan_id 1
        DB::table('klien_perusahaan')->insert([
            [
                'id_user' => 1,
                'id_perusahaan' => 1,
                'jabatan' => 'HSE Manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'id_perusahaan' => 2,
                'jabatan' => 'HR Staff',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
