<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Hapus tabel bawaan Laravel yang tidak digunakan sistem Veritas:
 *  - personal_access_tokens : Sanctum API token — sistem tidak menggunakan API/token.
 *  - failed_jobs            : Queue — sistem tidak menggunakan job queue (email sinkron).
 *  - password_resets        : Bawaan Laravel Auth — reset password sudah via OTP kustom (tabel otp_codes).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('password_resets');
    }

    public function down(): void
    {
        // Buat ulang tabel-tabel bawaan Laravel jika rollback
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }
};
