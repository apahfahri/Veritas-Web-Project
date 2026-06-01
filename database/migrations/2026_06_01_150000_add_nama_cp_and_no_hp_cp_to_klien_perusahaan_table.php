<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable()->change();
            $table->string('nama_cp')->nullable()->after('id_user');
            $table->string('no_hp_cp', 50)->nullable()->after('nama_cp');
        });
    }

    public function down(): void
    {
        Schema::table('klien_perusahaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable(false)->change();
            $table->dropColumn(['nama_cp', 'no_hp_cp']);
        });
    }
};
