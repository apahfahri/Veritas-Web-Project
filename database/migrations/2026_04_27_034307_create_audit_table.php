<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTable extends Migration
{
    public function up()
    {
        Schema::create('audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            $table->string('lingkup');
            $table->time('jam_pertemuan')->nullable();
            $table->date('tanggal_pertemuan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit');
    }
}
