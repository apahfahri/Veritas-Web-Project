<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use Illuminate\Database\Seeder;

class PerusahaanSeeder extends Seeder
{
    public function run()
    {
        $perusahaan = [
            [
                'nama'             => 'PT Adhi Karya (Persero) Tbk',
                'alamat'           => 'Jl. Raya Pasar Minggu No.18, Jakarta Selatan',
                'nib_oss'          => '9120101234567',
                'npwp_perusahaan'  => '01.234.567.8-012.000',
                'sektor_industri'  => 'Konstruksi',
                'jumlah_karyawan'  => 500,
            ],
            [
                'nama'             => 'PT Pertamina (Persero)',
                'alamat'           => 'Jl. Medan Merdeka Timur No.1A, Jakarta Pusat',
                'nib_oss'          => '8120109876543',
                'npwp_perusahaan'  => '01.987.654.3-098.000',
                'sektor_industri'  => 'Energi & Migas',
                'jumlah_karyawan'  => 2000,
            ],
            [
                'nama'             => 'PT Unilever Indonesia Tbk',
                'alamat'           => 'Jl. BSD Boulevard Barat Kav. AH2 No.1, Tangerang',
                'nib_oss'          => '7120105554443',
                'npwp_perusahaan'  => '01.555.444.3-555.000',
                'sektor_industri'  => 'Consumer Goods',
                'jumlah_karyawan'  => 1500,
            ],
        ];

        foreach ($perusahaan as $data) {
            Perusahaan::create($data);
        }
    }
}
