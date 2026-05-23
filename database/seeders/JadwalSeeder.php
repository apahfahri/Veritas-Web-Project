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

        $createJadwal = function($kode_jenis, $data, $pemateriIds) use ($katPelatihan) {
            $jenis = JenisLayanan::where('kode_jenis', $kode_jenis)->first();
            if (!$jenis) return;

            $urutan = Jadwal::where('id_jenis', $jenis->id_jenis)->count() + 1;
            $kode_jadwal = $katPelatihan->kode_kategori . '-' . $jenis->kode_jenis . '-' . str_pad($urutan, 2, '0', STR_PAD_LEFT);
            
            $data['kode_jadwal'] = $kode_jadwal;
            $data['id_kategori'] = $katPelatihan->id_kategori;
            $data['id_jenis'] = $jenis->id_jenis;

            $j = Jadwal::create($data);
            $j->pemateri()->sync($pemateriIds);
        };

        // ==========================
        // COMPLETED SCHEDULES (PAST)
        // ==========================

        // 1. Ahli K3 Umum (AK3U) - Selesai
        $createJadwal('AK3U', [
            'jenis_pertemuan' => 'offline',
            'tgl_mulai' => now()->subDays(30),
            'tgl_selesai' => now()->subDays(26),
            'jam_pertemuan' => '08:00:00',
            'lokasi' => 'Hotel Aston Bandung',
            'kapasitas' => 30,
            'harga' => 5000000,
            'deskripsi' => 'Pelatihan Ahli K3 Umum (Batch Sebelumnya).',
        ], [3, 4]);

        // 2. Auditor SMK3 (ASMK3) - Selesai
        $createJadwal('ASMK3', [
            'jenis_pertemuan' => 'hybrid',
            'tgl_mulai' => now()->subDays(15),
            'tgl_selesai' => now()->subDays(12),
            'jam_pertemuan' => '08:30:00',
            'lokasi' => 'Zoom & Hotel Hilton Jakarta',
            'kapasitas' => 20,
            'harga' => 6500000,
            'deskripsi' => 'Pelatihan Auditor SMK3 (Batch Sebelumnya).',
        ], [5]);

        // 3. Juru Las/Welder (WELD) - Selesai
        $createJadwal('WELD', [
            'jenis_pertemuan' => 'offline',
            'tgl_mulai' => now()->subDays(5),
            'tgl_selesai' => now()->subDays(2),
            'jam_pertemuan' => '08:00:00',
            'lokasi' => 'Workshop Las Jakarta',
            'kapasitas' => 15,
            'harga' => 4500000,
            'deskripsi' => 'Pelatihan Juru Las / Welder bersertifikat.',
        ], [6, 7]);

        // 4. Ahli K3 Lingkungan Kerja (AK3LK) - Selesai
        $createJadwal('AK3LK', [
            'jenis_pertemuan' => 'online',
            'tgl_mulai' => now()->subDays(10),
            'tgl_selesai' => now()->subDays(8),
            'jam_pertemuan' => '09:00:00',
            'lokasi' => 'Zoom Meeting',
            'kapasitas' => 40,
            'harga' => 3000000,
            'deskripsi' => 'Pelatihan Ahli K3 Lingkungan Kerja (Online).',
        ], [8, 9]);

        // ==========================
        // UPCOMING SCHEDULES (FUTURE)
        // ==========================

        // 5. Ahli K3 Umum (AK3U) - Akan Datang
        $createJadwal('AK3U', [
            'jenis_pertemuan' => 'offline',
            'tgl_mulai' => now()->addDays(10),
            'tgl_selesai' => now()->addDays(14),
            'jam_pertemuan' => '08:00:00',
            'lokasi' => 'Hotel Aston Bandung',
            'kapasitas' => 30,
            'harga' => 5000000,
            'deskripsi' => 'Pelatihan Ahli K3 Umum sertifikasi Kemnaker RI.',
        ], [1, 10]);

        // 6. Auditor SMK3 (ASMK3) - Akan Datang
        $createJadwal('ASMK3', [
            'jenis_pertemuan' => 'offline',
            'tgl_mulai' => now()->addDays(15),
            'tgl_selesai' => now()->addDays(18),
            'jam_pertemuan' => '08:00:00',
            'lokasi' => 'Hotel Hilton Jakarta',
            'kapasitas' => 20,
            'harga' => 6500000,
            'deskripsi' => 'Pelatihan Auditor SMK3 sertifikasi Kemnaker RI.',
        ], [2, 5]);

        // 7. Tenaga Kerja Bangunan Tinggi (TKBT) - Akan Datang
        $createJadwal('TKBT', [
            'jenis_pertemuan' => 'offline',
            'tgl_mulai' => now()->addDays(20),
            'tgl_selesai' => now()->addDays(22),
            'jam_pertemuan' => '08:00:00',
            'lokasi' => 'Training Center Veritas',
            'kapasitas' => 15,
            'harga' => 3500000,
            'deskripsi' => 'Pelatihan TKBT sertifikasi Kemnaker RI.',
        ], [1, 3]);

        // 8. Petugas K3 Kimia & Ahli K3 Kimia (AK3KIM) - Akan Datang
        $createJadwal('AK3KIM', [
            'jenis_pertemuan' => 'online',
            'tgl_mulai' => now()->addDays(12),
            'tgl_selesai' => now()->addDays(15),
            'jam_pertemuan' => '09:00:00',
            'lokasi' => 'Zoom Meeting',
            'kapasitas' => 40,
            'harga' => 4000000,
            'deskripsi' => 'Pelatihan Petugas & Ahli K3 Kimia Kemnaker RI.',
        ], [6, 2]);

        // 9. SIO Operator Angkat Angkut (SIOAA) - Akan Datang
        $createJadwal('SIOAA', [
            'jenis_pertemuan' => 'offline',
            'tgl_mulai' => now()->addDays(25),
            'tgl_selesai' => now()->addDays(28),
            'jam_pertemuan' => '08:00:00',
            'lokasi' => 'Workshop Veritas Surabaya',
            'kapasitas' => 25,
            'harga' => 4500000,
            'deskripsi' => 'Pelatihan Lisensi K3 SIO Operator Angkat Angkut.',
        ], [10, 7]);

        // 10. Petugas P3K & Petugas Fireman (P3KFIRE) - Akan Datang
        $createJadwal('P3KFIRE', [
            'jenis_pertemuan' => 'online',
            'tgl_mulai' => now()->addDays(18),
            'tgl_selesai' => now()->addDays(20),
            'jam_pertemuan' => '09:00:00',
            'lokasi' => 'Zoom Meeting',
            'kapasitas' => 50,
            'harga' => 1500000,
            'deskripsi' => 'Pelatihan sertifikasi Petugas P3K & Pemadam Kebakaran.',
        ], [3, 8]);
    }
}
