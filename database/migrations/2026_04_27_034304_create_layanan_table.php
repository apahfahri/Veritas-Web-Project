<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayananTable extends Migration
{
    public function up()
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->unsignedBigInteger('id_kategori');
            $table->string('materi');
            $table->string('jenis_pertemuan');
            $table->date('tanggal_pertemuan');
            $table->time('jam_pertemuan');
            $table->string('lokasi');
            $table->integer('kapasitas')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_layanan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan');
    }
}
