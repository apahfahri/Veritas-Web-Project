<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriSeeder extends Seeder
{
    public function run()
    {
        Materi::create([
            'judul' => 'Modul Dasar Keselamatan dan Kesehatan Kerja (K3)',
            'file_path' => 'materi/modul_dasar_k3.pdf',
            'deskripsi' => 'Modul pengantar mengenai prinsip dasar K3, regulasi nasional, dan identifikasi bahaya.',
        ]);

        Materi::create([
            'judul' => 'Panduan Audit Sistem Manajemen K3 (SMK3)',
            'file_path' => 'materi/panduan_audit_smk3.pdf',
            'deskripsi' => 'Panduan langkah demi langkah pelaksanaan audit internal SMK3 berdasarkan regulasi terbaru.',
        ]);

        Materi::create([
            'judul' => 'Prosedur Bekerja di Ketinggian (TKBT)',
            'file_path' => 'materi/prosedur_tkbt.pdf',
            'deskripsi' => 'Materi standar keselamatan bekerja di ketinggian, alat pelindung jatuh, dan tanggap darurat.',
        ]);
    }
}
