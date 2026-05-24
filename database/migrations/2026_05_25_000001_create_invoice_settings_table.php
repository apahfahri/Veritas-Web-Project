<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->string('rekening_1_bank')->default('Bank Mandiri');
            $table->string('rekening_1_nomor')->default('131-00-1886111-1');
            $table->string('rekening_1_atas_nama')->default('PT Katiga Veritas Indonesia');
            $table->boolean('rekening_1_aktif')->default(true);
            $table->string('rekening_2_bank')->nullable();
            $table->string('rekening_2_nomor')->nullable();
            $table->string('rekening_2_atas_nama')->nullable();
            $table->boolean('rekening_2_aktif')->default(false);
            $table->text('catatan_invoice')->nullable();
            $table->timestamps();
        });

        // Seed default row
        \DB::table('invoice_settings')->insert([
            'rekening_1_bank' => 'Bank Mandiri',
            'rekening_1_nomor' => '131-00-1886111-1',
            'rekening_1_atas_nama' => 'PT Katiga Veritas Indonesia',
            'rekening_1_aktif' => true,
            'rekening_2_bank' => null,
            'rekening_2_nomor' => null,
            'rekening_2_atas_nama' => null,
            'rekening_2_aktif' => false,
            'catatan_invoice' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
