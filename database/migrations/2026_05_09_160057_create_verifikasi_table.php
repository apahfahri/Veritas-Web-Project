<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifikasiTable extends Migration
{
    public function up()
    {
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('no_sertifikat')->nullable(); // nomor yang diketik pengguna
            $table->string('sertifikat_no')->nullable(); // nomor sertifikat yang ditemukan di sistem
            $table->enum('status', ['valid', 'tidak_valid', 'tidak_ditemukan'])->default('tidak_ditemukan');
            $table->text('catatan')->nullable();         // catatan tambahan
            $table->string('ip_address')->nullable();   // IP address peminta
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verifikasi');
    }
}
