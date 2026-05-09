<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestPelatihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('request_pelatihan', function (Blueprint $table) {
            $table->id('id_request');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_telp');
            $table->string('nama_perusahaan');
            $table->string('jabatan')->nullable();
            $table->text('alamat_perusahaan');
            $table->string('sektor_industri')->nullable();
            $table->integer('jumlah_karyawan')->nullable();
            $table->string('topik_pelatihan');
            $table->date('tanggal_harapan')->nullable();
            $table->text('pesan_tambahan')->nullable();
            $table->string('status')->default('pending'); // pending, dihubungi, selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_pelatihan');
    }
}
