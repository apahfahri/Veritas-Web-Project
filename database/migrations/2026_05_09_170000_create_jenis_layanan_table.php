<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('jenis_layanan')) {
            Schema::create('jenis_layanan', function (Blueprint $table) {
                $table->bigIncrements('id_jenis');
                $table->unsignedBigInteger('id_kategori');
                $table->string('nama');
                $table->timestamps();

                $table->foreign('id_kategori')
                      ->references('id_kategori')
                      ->on('kategori_layanan')
                      ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('jenis_layanan');
    }
}
