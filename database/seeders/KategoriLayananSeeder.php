<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriLayananSeeder extends Seeder
{
    public function run()
    {
        // 1. Pelatihan
        $pelatihan = \App\Models\KategoriLayanan::updateOrCreate(
            ['nama' => 'Pelatihan K3'],
            ['deskripsi' => 'Program pelatihan sertifikasi dan kompetensi.']
        );

        $jenisPelatihan = [
            'Ahli K3 Umum',
            'Ahli K3 Listrik',
            'Ahli K3 Konstruksi',
            'Petugas Peran Kebakaran',
            'Petugas P3K',
            'Operator Forklift',
            'Operator Crane',
        ];

        foreach ($jenisPelatihan as $j) {
            \App\Models\JenisLayanan::updateOrCreate([
                'id_kategori' => $pelatihan->id_kategori,
                'nama' => $j
            ]);
        }

        // 2. Konsultasi
        $konsultasi = \App\Models\KategoriLayanan::updateOrCreate(
            ['nama' => 'Konsultasi SMK3'],
            ['deskripsi' => 'Layanan konsultasi sistem manajemen dan teknis.']
        );

        $jenisKonsultasi = [
            'ISO 9001:2015 (Mutu)',
            'ISO 14001:2015 (Lingkungan)',
            'ISO 45001:2018 (K3)',
        ];

        foreach ($jenisKonsultasi as $j) {
            \App\Models\JenisLayanan::updateOrCreate([
                'id_kategori' => $konsultasi->id_kategori,
                'nama' => $j
            ]);
        }

        // 3. Audit
        \App\Models\KategoriLayanan::updateOrCreate(
            ['nama' => 'Audit K3'],
            ['deskripsi' => 'Layanan audit internal dan eksternal.']
        );
    }
}
