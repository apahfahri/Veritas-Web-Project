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
            $table->string('no_sertifikat'); // nomor yang diinput user untuk dicek
            $table->foreignId('sertifikat_id')->nullable()->constrained('sertifikat')->onDelete('set null');
            $table->enum('status', ['valid', 'tidak_valid', 'tidak_ditemukan'])->default('tidak_ditemukan');
            $table->text('catatan')->nullable();
            $table->string('ip_address', 45)->nullable(); // log IP untuk keamanan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verifikasi');
    }
}
