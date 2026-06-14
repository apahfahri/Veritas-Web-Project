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
            ],
            [
                'nama' => 'PT PetroGas Utama',
                'alamat' => 'Sudirman Central Business District Lot 21, Jakarta',
                'sektor_industri' => 'Minyak dan Gas',
                'jumlah_karyawan' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Adhi Karya Konstruksi',
                'alamat' => 'Jl. Gatot Subroto No. 44, Jakarta',
                'sektor_industri' => 'Konstruksi',
                'jumlah_karyawan' => 850,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Nusantara Coal Mining',
                'alamat' => 'Jl. Jendral Sudirman No. 18, Balikpapan',
                'sektor_industri' => 'Pertambangan',
                'jumlah_karyawan' => 2100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT IndoLogistik Ekspres',
                'alamat' => 'Jl. Pelabuhan Tanjung Perak No. 12, Surabaya',
                'sektor_industri' => 'Logistik dan Transportasi',
                'jumlah_karyawan' => 450,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Samudera Steel',
                'alamat' => 'Kawasan Industri Cilegon Banten',
                'sektor_industri' => 'Manufaktur Baja',
                'jumlah_karyawan' => 980,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Sentosa Pharma',
                'alamat' => 'Jl. Jababeka Raya Blok C No. 5, Bekasi',
                'sektor_industri' => 'Farmasi dan Kesehatan',
                'jumlah_karyawan' => 600,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Cahaya Abadi Elektrindo',
                'alamat' => 'Kawasan Industri Cikarang, Bekasi',
                'sektor_industri' => 'Elektronik',
                'jumlah_karyawan' => 350,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Global Finance Asia',
                'alamat' => 'Thamrin Tower Lt. 12, Jakarta',
                'sektor_industri' => 'Keuangan dan Perbankan',
                'jumlah_karyawan' => 400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Agro Lestari Nusantara',
                'alamat' => 'Jl. Diponegoro No. 89, Pekanbaru',
                'sektor_industri' => 'Pertanian dan Perkebunan',
                'jumlah_karyawan' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Technologi Baru Indonesia',
                'alamat' => 'Mega Kuningan Barat, Jakarta',
                'sektor_industri' => 'Teknologi Informasi',
                'jumlah_karyawan' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Pembangkit Listrik Jawa-Bali',
                'alamat' => 'Jl. Ketintang Baru No. 11, Surabaya',
                'sektor_industri' => 'Energi dan Utilitas',
                'jumlah_karyawan' => 1100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Hotelindo Nusantara',
                'alamat' => 'Jl. Malioboro No. 34, Yogyakarta',
                'sektor_industri' => 'Pariwisata dan Perhotelan',
                'jumlah_karyawan' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Wira Security Indonesia',
                'alamat' => 'Jl. Pemuda No. 78, Semarang',
                'sektor_industri' => 'Jasa Keamanan',
                'jumlah_karyawan' => 750,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
