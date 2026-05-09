<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    public function run()
    {
        DB::table('layanan')->insert([
            [
                'id_kategori' => 1, // Pelatihan K3
                'nama' => 'Pelatihan Ahli K3 Umum',
                'materi' => 'Ahli K3 Umum',
                'jenis_pertemuan' => 'offline',
                'tanggal_pertemuan' => now()->addDays(10)->toDateString(),
                'jam_pertemuan' => '08:00:00',
                'lokasi' => 'Hotel Aston Jakarta',
                'kapasitas' => 30,
                'harga' => 5000000,
                'deskripsi' => 'Pelatihan Ahli K3 Umum tersertifikasi Kemnaker.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 1, // Pelatihan K3
                'nama' => 'Pelatihan Petugas P3K',
                'materi' => 'Petugas P3K',
                'jenis_pertemuan' => 'online',
                'tanggal_pertemuan' => now()->addDays(15)->toDateString(),
                'jam_pertemuan' => '09:00:00',
                'lokasi' => 'Zoom Meeting',
                'kapasitas' => 50,
                'harga' => 1500000,
                'deskripsi' => 'Pelatihan Petugas Pertolongan Pertama Pada Kecelakaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2, // Konsultasi SMK3
                'nama' => 'Konsultasi Sertifikasi SMK3',
                'materi' => 'SMK3',
                'jenis_pertemuan' => 'offline',
                'tanggal_pertemuan' => now()->addDays(20)->toDateString(),
                'jam_pertemuan' => '09:00:00',
                'lokasi' => 'Kantor Klien / Veritas Office',
                'kapasitas' => null,
                'harga' => 0,
                'deskripsi' => 'Layanan konsultasi persiapan sertifikasi SMK3.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 3, // Audit K3
                'nama' => 'Audit Internal K3',
                'materi' => 'Audit K3',
                'jenis_pertemuan' => 'offline',
                'tanggal_pertemuan' => now()->addDays(25)->toDateString(),
                'jam_pertemuan' => '09:00:00',
                'lokasi' => 'Kantor Klien',
                'kapasitas' => null,
                'harga' => 0,
                'deskripsi' => 'Layanan audit internal untuk kepatuhan K3.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
