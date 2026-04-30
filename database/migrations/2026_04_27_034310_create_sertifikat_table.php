<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatTable extends Migration
{
    public function up()
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->string('no_sertifikat')->unique(); // nomor sertifikat unik (format string)
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->string('nama_lengkap'); // snapshot nama penerima saat sertifikat diterbitkan
            $table->date('tanggal_terbit');
            $table->string('file')->nullable(); // path file PDF sertifikat
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikat');
    }
}
