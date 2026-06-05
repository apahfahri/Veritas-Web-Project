<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SertifikatSeeder extends Seeder
{
    public function run()
    {
        DB::table('sertifikat')->insert([
            [
                'no_sertifikat'  => 'KV-K3-2026-000001',
                'id_pendaftaran' => 1,
                'nama_lengkap'   => 'Ahmad Fauzi Ramadan',
                'tanggal_terbit' => now()->subDays(28)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-K3-2026-000002',
                'id_pendaftaran' => 2,
                'nama_lengkap'   => 'Budi Santoso',
                'tanggal_terbit' => now()->subDays(14)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-SMK3-2026-000001',
                'id_pendaftaran' => 1,
                'nama_lengkap'   => 'Dewi Puspitasari',
                'tanggal_terbit' => now()->subDays(12)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-SMK3-2026-000002',
                'id_pendaftaran' => 2,
                'nama_lengkap'   => 'Rizky Ananda Putra',
                'tanggal_terbit' => now()->subDays(10)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-WELD-2026-000001',
                'id_pendaftaran' => 1,
                'nama_lengkap'   => 'Hendra Kurniawan',
                'tanggal_terbit' => now()->subDays(4)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-WELD-2026-000002',
                'id_pendaftaran' => 2,
                'nama_lengkap'   => 'Siti Nurhaliza',
                'tanggal_terbit' => now()->subDays(3)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-LK-2026-000001',
                'id_pendaftaran' => 1,
                'nama_lengkap'   => 'Andi Wijaya Kusuma',
                'tanggal_terbit' => now()->subDays(9)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-LK-2026-000002',
                'id_pendaftaran' => 2,
                'nama_lengkap'   => 'Fitriani Rahayu',
                'tanggal_terbit' => now()->subDays(8)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-P3K-2025-000001',
                'id_pendaftaran' => 1,
                'nama_lengkap'   => 'Muhamad Yusuf Hidayat',
                'tanggal_terbit' => now()->subMonths(6)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'no_sertifikat'  => 'KV-K3-2025-000099',
                'id_pendaftaran' => 2,
                'nama_lengkap'   => 'Rini Setiawati',
                'tanggal_terbit' => now()->subMonths(3)->toDateString(),
                'file'           => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
