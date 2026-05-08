<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriLayananTable extends Migration
{
    public function up()
    {
        Schema::create('kategori_layanan', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_layanan');
    }
}
