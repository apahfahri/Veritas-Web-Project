<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('request_pelatihan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pendaftaran')->nullable()->after('id_perusahaan');
            
            $table->foreign('id_pendaftaran')
                  ->references('id_pendaftaran')
                  ->on('pendaftaran')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('request_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_pendaftaran']);
            $table->dropColumn('id_pendaftaran');
        });
    }
};
