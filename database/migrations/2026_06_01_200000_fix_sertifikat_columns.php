<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * PERBAIKAN BUG: Kolom sertifikat tidak sinkron antara DB dan Model.
 *
 * Masalah:
 *  - Kolom `file` ada di DB tapi tidak pernah dipakai kode manapun.
 *  - Kolom `file_pdf`, `penerbit`, `masa_berlaku` dipakai di model & controller
 *    tapi TIDAK ADA di database, sehingga data tersebut gagal tersimpan secara diam-diam.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            // Tambah kolom yang hilang (dipakai model tapi tidak ada di DB)
            if (!Schema::hasColumn('sertifikat', 'file_pdf')) {
                $table->string('file_pdf')->nullable()->after('tanggal_terbit');
            }
            if (!Schema::hasColumn('sertifikat', 'masa_berlaku')) {
                $table->date('masa_berlaku')->nullable()->after('file_pdf');
            }
            if (!Schema::hasColumn('sertifikat', 'penerbit')) {
                $table->string('penerbit')->nullable()->after('masa_berlaku');
            }
        });

        // Hapus kolom lama 'file' yang tidak dipakai kode manapun
        if (Schema::hasColumn('sertifikat', 'file')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                $table->dropColumn('file');
            });
        }
    }

    public function down(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            // Kembalikan kolom lama
            if (!Schema::hasColumn('sertifikat', 'file')) {
                $table->string('file')->nullable();
            }
            // Hapus kolom baru
            foreach (['file_pdf', 'masa_berlaku', 'penerbit'] as $col) {
                if (Schema::hasColumn('sertifikat', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
