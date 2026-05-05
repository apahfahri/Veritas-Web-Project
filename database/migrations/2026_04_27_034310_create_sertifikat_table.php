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
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->date('tanggal_terbit');
            $table->string('file')->nullable();
            $table->string('cabang')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikat');
    }
}
