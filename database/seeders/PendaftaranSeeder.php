<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran;

class PendaftaranSeeder extends Seeder
{
    public function run()
    {
        Pendaftaran::create([
            'id_jadwal' => 1,
            'id_admin' => 2, // admin bandung
            'id_user' => 1,
            'tanggal_daftar' => now()->subDays(5)->toDateString(),
            'status_progres' => 'selesai',
            'status_bayar' => 'lunas',
            'cabang' => 'Bandung',
            'id_perusahaan' => 1, // Link to a company
        ]);

        Pendaftaran::create([
            'id_jadwal' => 2,
            'id_admin' => 3, // admin jakarta
            'id_user' => 2,
            'tanggal_daftar' => now()->subDays(2)->toDateString(),
            'status_progres' => 'menunggu_pembayaran',
            'status_bayar' => 'belum_lunas',
            'cabang' => 'Jakarta',
            'id_perusahaan' => 1,
        ]);
    }
}
