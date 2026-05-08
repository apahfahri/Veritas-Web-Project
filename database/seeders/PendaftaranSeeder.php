<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendaftaranSeeder extends Seeder
{
    public function run()
    {
        DB::table('pendaftaran')->insert([
            [
                'id_layanan' => 1,
                'id_admin' => 2, // admin pusat
                'id_user' => 1,
                'tanggal_daftar' => now()->subDays(5)->toDateString(),
                'status_progres' => 'selesai',
                'status_bayar' => 'lunas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_layanan' => 2,
                'id_admin' => 3, // admin cabang
                'id_user' => 2,
                'tanggal_daftar' => now()->subDays(2)->toDateString(),
                'status_progres' => 'menunggu_pembayaran',
                'status_bayar' => 'belum_lunas',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
