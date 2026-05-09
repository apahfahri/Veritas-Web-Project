<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTanggalPertemuanNullableOnLayananTable extends Migration
{
    public function up()
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->date('tanggal_pertemuan')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('layanan', function (Blueprint $table) {
            $table->date('tanggal_pertemuan')->nullable(false)->change();
        });
    }
}
