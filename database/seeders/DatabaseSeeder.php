<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            PerusahaanSeeder::class,
            KlienPerusahaanSeeder::class,
            PemateriSeeder::class,
            KategoriLayananSeeder::class,  // Isi kategori, jenis, dan kode_jenis
            MateriSeeder::class,          // Jalankan sebelum jadwal agar jadwal bisa melampirkan materi
            JadwalSeeder::class,          // Jalankan setelah kategori/jenis selesai
            PendaftaranSeeder::class,   // Jalankan setelah jadwal selesai
            KlienIndividuSeeder::class,
        ]);
    }
}
