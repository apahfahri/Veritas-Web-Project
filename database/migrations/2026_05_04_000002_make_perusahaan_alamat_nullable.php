<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePerusahaanAlamatNullable extends Migration
{
    public function up()
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->text('alamat')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->text('alamat')->nullable(false)->change();
        });
    }
}
