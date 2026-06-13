<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemateriSeeder extends Seeder
{
    public function run()
    {
        DB::table('pemateri')->upsert([
            [
                'id_pemateri'  => 1,
                'nama_lengkap' => 'Dr. Budi Santoso, M.K.K.K.',
                'email'        => 'budi@example.com',
                'no_telp'      => '081234567890',
                'kompetensi'   => 'Ahli K3 Industri & Auditor SMK3',
                'foto'         => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Doktor di bidang Keselamatan & Kesehatan Kerja dari Universitas Indonesia.\n\n• 18 tahun pengalaman di industri manufaktur & pertambangan\n• Lead Auditor SMK3 tersertifikasi Kemnaker RI\n• Konsultan K3 di 40+ perusahaan multinasional\n• Penulis buku \"Implementasi SMK3 Berbasis Risiko\"",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 2,
                'nama_lengkap' => 'Ir. Siti Aminah, S.T., M.T.',
                'email'        => 'siti@example.com',
                'no_telp'      => '089876543210',
                'kompetensi'   => 'Spesialis Audit ISO & Higiene Industri',
                'foto'         => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Lead Auditor ISO 45001 & ISO 14001 bersertifikat internasional.\n\n• 15 tahun pengalaman sebagai auditor sistem manajemen\n• Certified Industrial Hygienist (CIH) — AIHA USA\n• Telah mengaudit 60+ perusahaan di Asia Tenggara\n• Trainer aktif program OHSAS & ISO di BNSP",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 3,
                'nama_lengkap' => 'Bambang Irawan, S.KM.',
                'email'        => 'bambang@example.com',
                'no_telp'      => '081122334455',
                'kompetensi'   => 'Instruktur P3K & Keselamatan Kebakaran',
                'foto'         => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Instruktur berlisensi BNSP bidang P3K & Fire Safety.\n\n• Mantan anggota Tim Rescue PT Pertamina (10 tahun)\n• Certified Fire Safety Inspector — NFPA USA\n• Melatih 3.000+ peserta P3K & pemadam kebakaran\n• Instruktur BPBD & PMI untuk pelatihan tanggap darurat",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 4,
                'nama_lengkap' => 'dr. Andika Putra, Sp.Ok.',
                'email'        => 'andika@example.com',
                'no_telp'      => '082233445566',
                'kompetensi'   => 'Kesehatan Kerja & K3 Fasyankes',
                'foto'         => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Dokter Spesialis Okupasi berlisensi Kemenkes RI.\n\n• Spesialis Kedokteran Kerja dari FK Universitas Gadjah Mada\n• Medical Officer tersertifikasi untuk industri migas & pertambangan\n• Konsultan Kesehatan Kerja di 20+ rumah sakit & klinik industri\n• Peneliti aktif bidang penyakit akibat kerja (PAK)",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 5,
                'nama_lengkap' => 'Agus Setiawan, S.T.',
                'email'        => 'agus@example.com',
                'no_telp'      => '083344556677',
                'kompetensi'   => 'Ahli K3 Konstruksi & Perancah',
                'foto'         => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Ahli K3 Konstruksi Utama tersertifikasi Kemnaker RI.\n\n• 12 tahun pengalaman di proyek infrastruktur skala besar\n• Certified Scaffolding Inspector — PASMA UK\n• Pernah bertugas di proyek jembatan & gedung bertingkat tinggi\n• Inspektur K3 di Kementerian Pekerjaan Umum (2012–2018)",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 6,
                'nama_lengkap' => 'Diana Lestari, S.Si.',
                'email'        => 'diana@example.com',
                'no_telp'      => '084455667788',
                'kompetensi'   => 'Ahli K3 Kimia & Pengendalian Lingkungan',
                'foto'         => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Ahli K3 Kimia & AMDAL tersertifikasi Kemnaker & KLHK.\n\n• Sarjana Kimia dari ITB, spesialis bahan berbahaya (B3)\n• Certified Hazardous Material Manager (CHMM) — IHMM USA\n• Konsultan lingkungan di industri petrokimia & farmasi\n• Pelatih program pengendalian tumpahan & limbah B3",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 7,
                'nama_lengkap' => 'Hendra Saputra, M.Eng.',
                'email'        => 'hendra@example.com',
                'no_telp'      => '085566778899',
                'kompetensi'   => 'Ahli K3 Listrik & Mekanik',
                'foto'         => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Ahli K3 Listrik Utama & Teknisi Mekanik Bersertifikat.\n\n• Master Teknik Elektro dari Universitas Diponegoro\n• Pemegang lisensi K3 Listrik Kemnaker RI (Utama)\n• Spesialis inspeksi instalasi listrik & peralatan bertekanan\n• Pernah bertugas di PLN & Schneider Electric Indonesia",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 8,
                'nama_lengkap' => 'Reza Pratama, S.T., M.Sc.',
                'email'        => 'reza@example.com',
                'no_telp'      => '086677889900',
                'kompetensi'   => 'Ahli K3 Migas & Confined Space',
                'foto'         => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Spesialis K3 Migas & Ruang Terbatas (Confined Space).\n\n• Master of Science (Occupational Safety) — Curtin University Australia\n• BOSIET & HUET Certified — OPITO Offshore\n• 10 tahun pengalaman di platform migas lepas pantai\n• Trainer IADC WellSharp & H2S Safety bersertifikat internasional",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 9,
                'nama_lengkap' => 'Nurul Huda, S.K.M., M.Epid.',
                'email'        => 'nurul@example.com',
                'no_telp'      => '087788990011',
                'kompetensi'   => 'Higiene Industri & Ergonomi Kerja',
                'foto'         => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Ahli Higiene Industri & Ergonomi Kerja Bersertifikat.\n\n• Master Epidemiologi dari Universitas Airlangga\n• Certified Industrial Hygienist Asia Pacific (CIHAP)\n• Spesialis pengukuran kebisingan, debu, & faktor fisik\n• Peneliti ergonomi di Balai K4 Kementerian Ketenagakerjaan",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_pemateri'  => 10,
                'nama_lengkap' => 'Wira Kesuma, S.T.',
                'email'        => 'wira@example.com',
                'no_telp'      => '088899001122',
                'kompetensi'   => 'Instruktur Operator Angkat Angkut',
                'foto'         => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=600&auto=format&fit=crop',
                'bio'          => "Instruktur SIO Operator Angkat Angkut Bersertifikat Kemnaker.\n\n• Teknik Mesin dari Politeknik Negeri Jakarta\n• Lisensi K3 Pesawat Angkat Angkut — Kemnaker RI\n• Mantan operator & supervisor crane PT Krakatau Steel\n• Melatih 500+ operator crane, forklift & rigging bersertifikat",
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ], ['id_pemateri'], ['foto', 'bio', 'nama_lengkap', 'kompetensi', 'updated_at']);
    }
}
