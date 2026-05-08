<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayananPemateriTable extends Migration
{
    public function up()
    {
        Schema::create('layanan_pemateri', function (Blueprint $table) {
            $table->unsignedBigInteger('id_layanan');
            $table->unsignedBigInteger('id_pemateri');
            $table->timestamps();

            $table->primary(['id_layanan', 'id_pemateri']);
            $table->foreign('id_layanan')->references('id_layanan')->on('layanan')->onDelete('cascade');
            $table->foreign('id_pemateri')->references('id_pemateri')->on('pemateri')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan_pemateri');
    }
}
