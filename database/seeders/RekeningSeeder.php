<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rekening;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Bank Mandiri
        Rekening::create([
            'nama_bank'      => 'Bank Mandiri',
            'nomor_rekening' => '131-00-1886111-1',
            'atas_nama'      => 'PT Katiga Veritas Indonesia',
            'status_aktif'   => true,
        ]);

        // Default Bank BCA (Inactive)
        Rekening::create([
            'nama_bank'      => 'Bank BCA',
            'nomor_rekening' => '800-1234-567',
            'atas_nama'      => 'PT Katiga Veritas Indonesia',
            'status_aktif'   => false,
        ]);
    }
}
