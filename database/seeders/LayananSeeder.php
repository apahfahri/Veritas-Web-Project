<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\Pelatihan;
use App\Models\Konsultasi;
use App\Models\Audit;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        // =========================================================
        // LAYANAN 1 — PELATIHAN K3
        // =========================================================
        $layananPelatihan = Layanan::create([
            'nama'      => 'Pelatihan K3',
            'deskripsi' => 'Program pelatihan Keselamatan dan Kesehatan Kerja (K3) yang komprehensif dan bersertifikat nasional. Dirancang untuk meningkatkan kompetensi dan kesadaran K3 di tempat kerja.',
        ]);

        Pelatihan::create([
            'layanan_id'       => $layananPelatihan->id,
            'materi'           => 'K3 Umum & Pengenalan Hazard',
            'jenis_pertemuan'  => 'offline',
            'jam_pertemuan'    => '08:00:00',
            'tanggal_pertemuan'=> '2026-05-15',
            'lokasi'           => 'Gedung Katiga Veritas, Jakarta Selatan',
            'kapasitas'        => 30,
            'deskripsi'        => 'Pelatihan dasar K3 mencakup pengenalan bahaya, penggunaan APD, dan prosedur tanggap darurat.',
        ]);

        Pelatihan::create([
            'layanan_id'       => $layananPelatihan->id,
            'materi'           => 'K3 Kebakaran & Evakuasi',
            'jenis_pertemuan'  => 'offline',
            'jam_pertemuan'    => '09:00:00',
            'tanggal_pertemuan'=> '2026-05-22',
            'lokasi'           => 'Gedung Katiga Veritas, Jakarta Selatan',
            'kapasitas'        => 25,
            'deskripsi'        => 'Pelatihan pencegahan dan penanganan kebakaran di tempat kerja beserta simulasi evakuasi.',
        ]);

        Pelatihan::create([
            'layanan_id'       => $layananPelatihan->id,
            'materi'           => 'K3 Online — HIRADC & Risk Assessment',
            'jenis_pertemuan'  => 'online',
            'jam_pertemuan'    => '13:00:00',
            'tanggal_pertemuan'=> '2026-06-05',
            'lokasi'           => null,
            'kapasitas'        => 50,
            'deskripsi'        => 'Pelatihan identifikasi bahaya dan penilaian risiko (HIRADC) secara daring via Zoom.',
        ]);

        // =========================================================
        // LAYANAN 2 — KONSULTASI K3
        // =========================================================
        $layananKonsultasi = Layanan::create([
            'nama'      => 'Konsultasi K3',
            'deskripsi' => 'Layanan konsultasi K3 profesional untuk membantu perusahaan memenuhi regulasi K3 yang berlaku, menyusun sistem manajemen K3, dan meningkatkan budaya keselamatan kerja.',
        ]);

        Konsultasi::create([
            'layanan_id'       => $layananKonsultasi->id,
            'jenis_pertemuan'  => 'online',
            'jam_pertemuan'    => '10:00:00',
            'tanggal_pertemuan'=> '2026-05-10',
            'topik'            => 'Penyusunan Sistem Manajemen K3 (SMK3)',
        ]);

        Konsultasi::create([
            'layanan_id'       => $layananKonsultasi->id,
            'jenis_pertemuan'  => 'offline',
            'jam_pertemuan'    => '14:00:00',
            'tanggal_pertemuan'=> '2026-05-20',
            'topik'            => 'Pemenuhan Regulasi K3 Pemerintah',
        ]);

        // =========================================================
        // LAYANAN 3 — AUDIT K3
        // =========================================================
        $layananAudit = Layanan::create([
            'nama'      => 'Audit K3',
            'deskripsi' => 'Layanan audit K3 independen untuk mengevaluasi efektivitas penerapan sistem manajemen K3 di perusahaan, sesuai standar OHSAS 18001 / ISO 45001.',
        ]);

        Audit::create([
            'layanan_id'       => $layananAudit->id,
            'lingkup'          => 'Audit Internal SMK3 PP 50/2012',
            'jam_pertemuan'    => '08:00:00',
            'tanggal_pertemuan'=> '2026-05-25',
            'deskripsi'        => 'Audit menyeluruh penerapan SMK3 sesuai Peraturan Pemerintah No. 50 Tahun 2012.',
        ]);

        Audit::create([
            'layanan_id'       => $layananAudit->id,
            'lingkup'          => 'Audit ISO 45001:2018',
            'jam_pertemuan'    => '09:00:00',
            'tanggal_pertemuan'=> '2026-06-10',
            'deskripsi'        => 'Audit kesesuaian sistem manajemen K3 terhadap standar internasional ISO 45001:2018.',
        ]);
    }
}
