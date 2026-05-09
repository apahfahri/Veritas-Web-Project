<?php

namespace Database\Seeders;

use App\Models\KlienIndividu;
use Illuminate\Database\Seeder;

class KlienIndividuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KlienIndividu::create([
            'user_id' => 1,
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'cabang' => 'padang',
        ]);

        KlienIndividu::create([
            'user_id' => 2,
            'nik' => '6543210987654321',
            'nama_lengkap' => 'Andi Wijaya',
            'no_hp' => '081298765432',
            'cabang' => 'pekanbaru',
        ]);
    }
}
