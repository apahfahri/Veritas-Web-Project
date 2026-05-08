<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatTable extends Migration
{
    public function up()
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->string('no_sertifikat')->primary();
            $table->unsignedBigInteger('id_pendaftaran');
            $table->string('nama_lengkap');
            $table->date('tanggal_terbit');
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikat');
    }
}
