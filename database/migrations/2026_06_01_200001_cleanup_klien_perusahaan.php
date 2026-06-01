<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Bersihkan kolom tidak terpakai di tabel klien_perusahaan:
 *  - `is_pic`      : selalu default true, tidak ada kode yang membaca/memfilternya.
 *  - `status_mitra`: selalu default 'aktif', tidak ada UI atau logika yang mengelolanya.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('klien_perusahaan', 'is_pic')) {
                $cols[] = 'is_pic';
            }
            if (Schema::hasColumn('klien_perusahaan', 'status_mitra')) {
                $cols[] = 'status_mitra';
            }
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }

    public function down(): void
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            if (!Schema::hasColumn('klien_perusahaan', 'is_pic')) {
                $table->boolean('is_pic')->default(true)->after('jabatan');
            }
            if (!Schema::hasColumn('klien_perusahaan', 'status_mitra')) {
                $table->string('status_mitra')->default('aktif')->after('is_pic');
            }
        });
    }
};
