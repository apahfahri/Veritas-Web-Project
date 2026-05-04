<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCabangToAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->string('cabang')->nullable(); // jambi, lampung, jakarta
        });

        Schema::table('layanan', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('perusahaan', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('klien_individu', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('pelatihan', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('sertifikat', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('layanan', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('klien_individu', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
    }
}

