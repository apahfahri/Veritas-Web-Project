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
            UserAdminSeeder::class,  // 1. Users & Admin (tidak ada FK eksternal)
            PetugasSeeder::class,    // 2. Petugas (tidak ada FK eksternal)
            LayananSeeder::class,    // 3. Layanan + Pelatihan + Konsultasi + Audit
            // PendaftaranSeeder::class — tambahkan nanti setelah ada data klien
            // SertifikatSeeder::class — tambahkan nanti setelah ada pendaftaran selesai
        ]);
    }
}
