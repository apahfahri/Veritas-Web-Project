<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemateriTable extends Migration
{
    public function up()
    {
        Schema::create('pemateri', function (Blueprint $table) {
            $table->id('id_pemateri');
            $table->string('nama_lengkap');
            $table->string('email')->nullable()->unique();
            $table->string('no_telp')->nullable();
            $table->string('kompetensi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemateri');
    }
}
