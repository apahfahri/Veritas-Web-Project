<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeJamPertemuanAndLokasiNullableOnLayananTable extends Migration
{
    public function up()
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->time('jam_pertemuan')->nullable()->change();
            $table->string('lokasi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->time('jam_pertemuan')->nullable(false)->change();
            $table->string('lokasi')->nullable(false)->change();
        });
    }
}
