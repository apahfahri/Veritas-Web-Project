<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\JenisLayanan;
use App\Models\KategoriLayanan;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        // Cari kategori Pelatihan K3
        $katPelatihan = KategoriLayanan::where('nama', 'like', '%Pelatihan%')->first();

        if (!$katPelatihan) {
            return;
        }

        // 1. Ahli K3 Umum (AK3U)
        $jenisAK3U = JenisLayanan::where('kode_jenis', 'AK3U')->first();
        if ($jenisAK3U) {
            $j1 = Jadwal::create([
                'id_kategori' => $katPelatihan->id_kategori,
                'id_jenis' => $jenisAK3U->id_jenis,
                'kode_jadwal' => 'PLT-AK3U-01',
                'jenis_pertemuan' => 'offline',
                'tgl_mulai' => now()->addDays(10),
                'tgl_selesai' => now()->addDays(14),
                'jam_pertemuan' => '08:00:00',
                'lokasi' => 'Hotel Aston Bandung',
                'kapasitas' => 30,
                'harga' => 5000000,
                'deskripsi' => 'Pelatihan Ahli K3 Umum sertifikasi Kemnaker RI.',
            ]);
            $j1->pemateri()->sync([1]);
        }

        // 2. Auditor SMK3 (ASMK3)
        $jenisASMK3 = JenisLayanan::where('kode_jenis', 'ASMK3')->first();
        if ($jenisASMK3) {
            $j2 = Jadwal::create([
                'id_kategori' => $katPelatihan->id_kategori,
                'id_jenis' => $jenisASMK3->id_jenis,
                'kode_jadwal' => 'PLT-ASMK3-02',
                'jenis_pertemuan' => 'offline',
                'tgl_mulai' => now()->addDays(15),
                'tgl_selesai' => now()->addDays(18),
                'jam_pertemuan' => '08:00:00',
                'lokasi' => 'Hotel Hilton Jakarta',
                'kapasitas' => 20,
                'harga' => 6500000,
                'deskripsi' => 'Pelatihan Auditor SMK3 sertifikasi Kemnaker RI.',
            ]);
            $j2->pemateri()->sync([2]);
        }

        // 3. Tenaga Kerja Bangunan Tinggi (TKBT) (TKBT)
        $jenisTKBT = JenisLayanan::where('kode_jenis', 'TKBT')->first();
        if ($jenisTKBT) {
            $j3 = Jadwal::create([
                'id_kategori' => $katPelatihan->id_kategori,
                'id_jenis' => $jenisTKBT->id_jenis,
                'kode_jadwal' => 'PLT-TKBT-03',
                'jenis_pertemuan' => 'offline',
                'tgl_mulai' => now()->addDays(20),
                'tgl_selesai' => now()->addDays(22),
                'jam_pertemuan' => '08:00:00',
                'lokasi' => 'Training Center Veritas',
                'kapasitas' => 15,
                'harga' => 3500000,
                'deskripsi' => 'Pelatihan TKBT sertifikasi Kemnaker RI.',
            ]);
            $j3->pemateri()->sync([1]);
        }

        // 4. Petugas K3 Kimia & Ahli K3 Kimia (AK3KIM)
        $jenisAK3Kim = JenisLayanan::where('kode_jenis', 'AK3KIM')->first();
        if ($jenisAK3Kim) {
            $j4 = Jadwal::create([
                'id_kategori' => $katPelatihan->id_kategori,
                'id_jenis' => $jenisAK3Kim->id_jenis,
                'kode_jadwal' => 'PLT-AK3KIM-04',
                'jenis_pertemuan' => 'online',
                'tgl_mulai' => now()->addDays(12),
                'tgl_selesai' => now()->addDays(15),
                'jam_pertemuan' => '09:00:00',
                'lokasi' => 'Zoom Meeting',
                'kapasitas' => 40,
                'harga' => 4000000,
                'deskripsi' => 'Pelatihan Petugas & Ahli K3 Kimia Kemnaker RI.',
            ]);
            $j4->pemateri()->sync([2]);
        }

        // 5. SIO Operator Angkat Angkut (SIOAA)
        $jenisSIOAA = JenisLayanan::where('kode_jenis', 'SIOAA')->first();
        if ($jenisSIOAA) {
            $j5 = Jadwal::create([
                'id_kategori' => $katPelatihan->id_kategori,
                'id_jenis' => $jenisSIOAA->id_jenis,
                'kode_jadwal' => 'PLT-SIOAA-05',
                'jenis_pertemuan' => 'offline',
                'tgl_mulai' => now()->addDays(25),
                'tgl_selesai' => now()->addDays(28),
                'jam_pertemuan' => '08:00:00',
                'lokasi' => 'Workshop Veritas Surabaya',
                'kapasitas' => 25,
                'harga' => 4500000,
                'deskripsi' => 'Pelatihan Lisensi K3 SIO Operator Angkat Angkut.',
            ]);
            $j5->pemateri()->sync([1]);
        }

        // 6. Petugas P3K & Petugas Fireman (P3KFIRE)
        $jenisP3KFire = JenisLayanan::where('kode_jenis', 'P3KFIRE')->first();
        if ($jenisP3KFire) {
            $j6 = Jadwal::create([
                'id_kategori' => $katPelatihan->id_kategori,
                'id_jenis' => $jenisP3KFire->id_jenis,
                'kode_jadwal' => 'PLT-P3KFIRE-06',
                'jenis_pertemuan' => 'online',
                'tgl_mulai' => now()->addDays(18),
                'tgl_selesai' => now()->addDays(20),
                'jam_pertemuan' => '09:00:00',
                'lokasi' => 'Zoom Meeting',
                'kapasitas' => 50,
                'harga' => 1500000,
                'deskripsi' => 'Pelatihan sertifikasi Petugas P3K & Pemadam Kebakaran.',
            ]);
            $j6->pemateri()->sync([1, 2]);
        }
    }
}
