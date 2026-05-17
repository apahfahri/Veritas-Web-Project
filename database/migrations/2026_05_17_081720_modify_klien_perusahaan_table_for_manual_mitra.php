<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyKlienPerusahaanTableForManualMitra extends Migration
{
    public function up()
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            // Buat id_user nullable agar admin bisa input manual tanpa user terdaftar
            $table->unsignedBigInteger('id_user')->nullable()->change();
            // Tambah kolom nama CP manual
            $table->string('nama_cp')->nullable()->after('id_user');
            // Tambah kolom no hp CP manual
            $table->string('no_hp_cp')->nullable()->after('nama_cp');
        });
    }

    public function down()
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->dropColumn(['nama_cp', 'no_hp_cp']);
            $table->unsignedBigInteger('id_user')->nullable(false)->change();
        });
    }
}
