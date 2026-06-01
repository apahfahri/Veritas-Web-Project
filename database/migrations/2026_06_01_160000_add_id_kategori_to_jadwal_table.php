<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add id_kategori column if it does not exist
        if (!Schema::hasColumn('jadwal', 'id_kategori')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->unsignedBigInteger('id_kategori')->after('id_jadwal');
                $table->foreign('id_kategori')
                    ->references('id_kategori')
                    ->on('kategori_layanan')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropColumn('id_kategori');
        });
    }
};
