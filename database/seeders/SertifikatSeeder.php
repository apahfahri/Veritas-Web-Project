<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SertifikatSeeder extends Seeder
{
    public function run()
    {
        DB::table('sertifikat')->insert([
            [
                'no_sertifikat' => 'CERT-K3-2026-0001',
                'id_pendaftaran' => 1,
                'nama_lengkap' => 'Budi Santoso',
                'tanggal_terbit' => now()->subDays(1)->toDateString(),
                'file' => 'sertifikat/budi_santoso.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
