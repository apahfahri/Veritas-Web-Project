<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;

class KategoriLayananSeeder extends Seeder
{
    public function run()
    {
        // ═══════════════════════════════════════════════════════
        // 1. PELATIHAN K3
        // ═══════════════════════════════════════════════════════
        $pelatihan = KategoriLayanan::updateOrCreate(
            ['nama' => 'Pelatihan K3'],
            [
                'kode_kategori' => 'PLT',
                'deskripsi'     => 'Program pelatihan sertifikasi dan kompetensi Keselamatan dan Kesehatan Kerja.',
            ]
        );

        $jenisPelatihan = [
            ['nama' => 'Ahli K3 Umum',                                                               'kode_jenis' => 'AK3U'],
            ['nama' => 'Auditor SMK3',                                                                'kode_jenis' => 'ASMK3'],
            ['nama' => 'Tenaga Kerja Bangunan Tinggi (TKBT)',                                         'kode_jenis' => 'TKBT'],
            ['nama' => 'SIO Operator Boiler',                                                         'kode_jenis' => 'SIOB'],
            ['nama' => 'Petugas K3 Kimia & Ahli K3 Kimia',                                           'kode_jenis' => 'AK3KIM'],
            ['nama' => 'Petugas Kebakaran & P3K',                                                     'kode_jenis' => 'PKBRP3K'],
            ['nama' => 'Juru Las/Welder',                                                             'kode_jenis' => 'WELD'],
            ['nama' => 'SIO Operator Angkat Angkut',                                                  'kode_jenis' => 'SIOAA'],
            ['nama' => 'Ahli K3 Muda & Madya Konstruksi',                                             'kode_jenis' => 'AK3KON'],
            ['nama' => 'Ahli K3 Lingkungan Kerja',                                                    'kode_jenis' => 'AK3LK'],
            ['nama' => 'K3 Teknisi & Supervisi Perancah',                                             'kode_jenis' => 'K3PRNC'],
            ['nama' => 'K3 Teknisi/Ahli Listrik',                                                     'kode_jenis' => 'AK3LST'],
            ['nama' => 'Ahli K3 Umum, Operator K3 Umum, dan Teknisi K3 Umum',                        'kode_jenis' => 'AK3OTK'],
            ['nama' => 'Petugas, Supervisor, Ahli Muda, Ahli Madya, dan Ahli Utama K3 Konstruksi',   'kode_jenis' => 'SUPAK3K'],
            ['nama' => 'Inspektur Pesawat Angkat & Inspektur Kelistrikan',                            'kode_jenis' => 'INPAK'],
            ['nama' => 'Ahli Higiene Industri (Muda, Madya, Utama)',                                  'kode_jenis' => 'AHGIND'],
            ['nama' => 'Pengawas K3 & Operator K3 Minyak & Gas',                                     'kode_jenis' => 'K3MIGAS'],
            ['nama' => 'Pengawas Operasi Pertama & Madya',                                            'kode_jenis' => 'POPMDYA'],
            ['nama' => 'Petugas P3K & Petugas Fireman',                                               'kode_jenis' => 'P3KFIRE'],
            ['nama' => 'Operator & Supervisor Perancah',                                              'kode_jenis' => 'OPRNC'],
            ['nama' => 'Training of Trainers (TOT) KKNI Level 3, Level 4, dan Master Trainer',        'kode_jenis' => 'TOT'],
            ['nama' => 'Ahli Muda & Madya Ruang Terbatas (Confined Space)',                           'kode_jenis' => 'CONFSP'],
            ['nama' => 'Authorized Gas Tester & Petugas Penanganan H2S',                              'kode_jenis' => 'AGTH2S'],
            ['nama' => 'Petugas K3 Fasyankes (Fasilitas Pelayanan Kesehatan)',                        'kode_jenis' => 'K3FSY'],
            ['nama' => 'Petugas K3 Kimia',                                                            'kode_jenis' => 'PK3KIM'],
            ['nama' => 'Penanggung Jawab (PJ) Pencemaran Udara & Air',                                'kode_jenis' => 'PJPUA'],
            ['nama' => 'Ahli Incident Investigation',                                                 'kode_jenis' => 'AII'],
        ];

        foreach ($jenisPelatihan as $j) {
            JenisLayanan::updateOrCreate(
                ['id_kategori' => $pelatihan->id_kategori, 'nama' => $j['nama']],
                ['kode_jenis'  => $j['kode_jenis']]
            );
        }

        // ═══════════════════════════════════════════════════════
        // 2. KONSULTASI SMK3
        // ═══════════════════════════════════════════════════════
        $konsultasi = KategoriLayanan::updateOrCreate(
            ['nama' => 'Konsultasi SMK3'],
            [
                'kode_kategori' => 'KST',
                'deskripsi'     => 'Layanan konsultasi sistem manajemen dan teknis K3.',
            ]
        );

        $jenisKonsultasi = [
            ['nama' => 'Konsultan Sistem Manajemen Keselamatan dan Kesehatan Kerja (SMK3)', 'kode_jenis' => 'KSMK3'],
            ['nama' => 'Konsultan bidang Process Safety (Process Safety Management / PSM)',  'kode_jenis' => 'KPSM'],
            ['nama' => 'Konsultasi Sistem Manajemen Mutu, K3, dan Lingkungan',              'kode_jenis' => 'KSMML'],
            ['nama' => 'Konsultasi Manajemen Risiko',                                       'kode_jenis' => 'KMR'],
        ];

        foreach ($jenisKonsultasi as $j) {
            JenisLayanan::updateOrCreate(
                ['id_kategori' => $konsultasi->id_kategori, 'nama' => $j['nama']],
                ['kode_jenis'  => $j['kode_jenis']]
            );
        }

        // ═══════════════════════════════════════════════════════
        // 3. AUDIT K3
        // ═══════════════════════════════════════════════════════
        $audit = KategoriLayanan::updateOrCreate(
            ['nama' => 'Audit K3'],
            [
                'kode_kategori' => 'ADT',
                'deskripsi'     => 'Layanan audit internal dan eksternal sistem manajemen K3.',
            ]
        );

        $jenisAudit = [
            ['nama' => 'Audit Sistem Manajemen K3 (SMK3)',                                                        'kode_jenis' => 'ADTSMK3'],
            ['nama' => 'Audit Sertifikasi ISO 9001 (Sistem Manajemen Mutu)',                                      'kode_jenis' => 'ISO9001'],
            ['nama' => 'Audit Sertifikasi ISO 14001 (Sistem Manajemen Lingkungan)',                               'kode_jenis' => 'ISO14001'],
            ['nama' => 'Audit Sertifikasi ISO 45001 (Sistem Manajemen Keselamatan dan Kesehatan Kerja)',          'kode_jenis' => 'ISO45001'],
        ];

        foreach ($jenisAudit as $j) {
            JenisLayanan::updateOrCreate(
                ['id_kategori' => $audit->id_kategori, 'nama' => $j['nama']],
                ['kode_jenis'  => $j['kode_jenis']]
            );
        }
    }
}
