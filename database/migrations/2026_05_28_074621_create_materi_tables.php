<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriTables extends Migration
{
    public function up()
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->id('id_materi');
            $table->string('judul');
            $table->string('file_path');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('jadwal_materi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_materi');
            $table->timestamps();

            $table->primary(['id_jadwal', 'id_materi']);
            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwal')
                  ->onDelete('cascade');
            $table->foreign('id_materi')
                  ->references('id_materi')
                  ->on('materi')
                  ->onDelete('cascade');
        });

        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('file_rundown')->nullable()->after('deskripsi');
            $table->timestamp('reminder_h3_sent_at')->nullable()->after('file_rundown');
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['file_rundown', 'reminder_h3_sent_at']);
        });
        Schema::dropIfExists('jadwal_materi');
        Schema::dropIfExists('materi');
    }
}
