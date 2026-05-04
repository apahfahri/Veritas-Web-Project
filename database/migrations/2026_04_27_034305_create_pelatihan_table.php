<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelatihanTable extends Migration
{
    public function up()
    {
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            $table->string('materi');
            $table->string('jenis_pertemuan'); // 'online', 'offline'
            $table->time('jam_pertemuan')->nullable();
            $table->date('tanggal_pertemuan')->nullable();
            $table->string('lokasi')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelatihan');
    }
}
