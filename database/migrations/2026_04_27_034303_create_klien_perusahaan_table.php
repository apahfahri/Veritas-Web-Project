<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienPerusahaanTable extends Migration
{
    public function up()
    {
        Schema::create('klien_perusahaan', function (Blueprint $table) {
            $table->id('id_k_perusahaan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_perusahaan');
            $table->string('jabatan')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('perusahaan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('klien_perusahaan');
    }
}
