<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupKlienIndividuAndUnusedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('klien_individu');

        if (Schema::hasColumn('pendaftaran', 'id_admin')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                // Drop the foreign key first if it exists
                // The previous migrations show id_admin was referencing admin table
                // Let's wrap it in a try-catch or check just in case the FK name is different, but Laravel convention is pendaftaran_id_admin_foreign
                $table->dropForeign(['id_admin']);
                $table->dropColumn('id_admin');
            });
        }
    }

    public function down()
    {
        // Recreate the column if down is called
        if (!Schema::hasColumn('pendaftaran', 'id_admin')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->unsignedBigInteger('id_admin')->nullable()->after('id_jadwal');
                $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('set null');
            });
        }
        
        // We won't recreate klien_individu in down() fully, just a stub
        if (!Schema::hasTable('klien_individu')) {
            Schema::create('klien_individu', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('nik', 16)->nullable();
                $table->string('nama_lengkap');
                $table->string('no_hp', 20)->nullable();
                $table->string('cabang')->default('pusat');
                $table->timestamps();
                
                $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            });
        }
    }
}
