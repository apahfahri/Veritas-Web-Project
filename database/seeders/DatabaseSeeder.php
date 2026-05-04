<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan penting — ikuti dependency FK.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserAdminSeeder::class,  // 1. Users & Admin
            PetugasSeeder::class,    // 2. Petugas
            LayananSeeder::class,    // 3. Layanan + Pelatihan
            PerusahaanSeeder::class, // 4. Data Perusahaan
            KlienSeeder::class,      // 5. Data Klien (Individu & Perusahaan)
            PendaftaranSeeder::class, // 6. Data Pendaftaran + Sertifikat
        ]);
    }
}
