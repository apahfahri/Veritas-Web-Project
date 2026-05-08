<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananPemateriSeeder extends Seeder
{
    public function run()
    {
        DB::table('layanan_pemateri')->insert([
            [
                'id_layanan' => 1,
                'id_pemateri' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_layanan' => 2,
                'id_pemateri' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
