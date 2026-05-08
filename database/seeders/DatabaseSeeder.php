<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            PerusahaanSeeder::class,
            KlienPerusahaanSeeder::class,
            KategoriLayananSeeder::class,
            LayananSeeder::class,
            PemateriSeeder::class,
            LayananPemateriSeeder::class,
            PendaftaranSeeder::class,
            SertifikatSeeder::class,
        ]);
    }
}
