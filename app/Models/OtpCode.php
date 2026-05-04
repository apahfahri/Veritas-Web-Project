<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpCode extends Model
{
    protected $fillable = ['email', 'otp', 'type', 'expired_at'];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Generate OTP 6 digit, hapus OTP lama untuk email+type ini,
     * lalu simpan yang baru.
     */
    public static function generate(string $email, string $type): string
    {
        // Hapus OTP lama untuk email + type ini
        static::where('email', $email)->where('type', $type)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        static::create([
            'email'      => $email,
            'otp'        => $otp,
            'type'       => $type,
            'expired_at' => Carbon::now()->addMinutes(10),
        ]);

        return $otp;
    }

    /**
     * Verifikasi OTP — return true jika valid, false jika tidak.
     */
    public static function verify(string $email, string $type, string $otp): bool
    {
        $record = static::where('email', $email)
                        ->where('type', $type)
                        ->where('otp', $otp)
                        ->first();

        if (!$record) {
            return false;
        }

        if (Carbon::now()->isAfter($record->expired_at)) {
            $record->delete();
            return false;
        }

        $record->delete();
        return true;
    }
}
