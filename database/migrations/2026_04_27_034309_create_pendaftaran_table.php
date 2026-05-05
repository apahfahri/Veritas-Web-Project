<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranTable extends Migration
{
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_daftar');
            $table->enum('status_progres', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->enum('status_bayar', ['belum_bayar', 'menunggu_konfirmasi', 'lunas'])->default('belum_bayar');
            $table->string('cabang')->nullable();
            $table->boolean('dokumen_lengkap')->default(false);
            $table->timestamp('last_reminder_sent_at')->nullable();
            $table->text('last_reminder_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
}
