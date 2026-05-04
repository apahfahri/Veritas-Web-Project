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
            $table->string('no_sertifikat');
            $table->string('sertifikat_no')->nullable();
            $table->foreign('sertifikat_no')->references('no_sertifikat')->on('sertifikat')->onDelete('set null');
            $table->enum('status', ['valid', 'tidak_valid', 'tidak_ditemukan'])->default('tidak_ditemukan');
            $table->text('catatan')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verifikasi');
    }
}
