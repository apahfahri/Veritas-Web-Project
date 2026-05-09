<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jadwal')->nullable()->after('id_layanan');
            $table->string('cabang')->nullable()->after('status_bayar');
            $table->boolean('is_utusan_perusahaan')->default(false)->after('id_user');
            $table->unsignedBigInteger('id_perusahaan')->nullable()->after('is_utusan_perusahaan');

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal')->onDelete('set null');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('set null');
        });

        Schema::table('klien_individu', function (Blueprint $table) {
            $table->unsignedBigInteger('id_perusahaan')->nullable()->after('no_hp');
            $table->string('jabatan')->nullable()->after('id_perusahaan');

            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['id_jadwal']);
            $table->dropForeign(['id_perusahaan']);
            $table->dropColumn(['id_jadwal', 'cabang', 'is_utusan_perusahaan', 'id_perusahaan']);
        });

        Schema::table('klien_individu', function (Blueprint $table) {
            $table->dropForeign(['id_perusahaan']);
            $table->dropColumn(['id_perusahaan', 'jabatan']);
        });
    }
};
