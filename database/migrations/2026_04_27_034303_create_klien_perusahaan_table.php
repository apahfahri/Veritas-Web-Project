<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienPerusahaanTable extends Migration
{
    public function up()
    {
        Schema::create('klien_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaan')->onDelete('set null');
            $table->string('nama_lengkap');
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('klien_perusahaan');
    }
}
