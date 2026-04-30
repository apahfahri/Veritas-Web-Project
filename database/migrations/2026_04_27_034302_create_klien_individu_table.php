<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienIndividuTable extends Migration
{
    public function up()
    {
        Schema::create('klien_individu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nik', 16)->nullable();
            $table->string('nama_lengkap');
            $table->string('no_hp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('klien_individu');
    }
}
