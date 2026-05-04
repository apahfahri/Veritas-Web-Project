<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $type;     // 'register' | 'forgot_password'
    public string $expiry;   // "10 menit"

    public function __construct(string $otp, string $type)
    {
        $this->otp    = $otp;
        $this->type   = $type;
        $this->expiry = '10 menit';
    }

    public function build(): static
    {
        $subject = $this->type === 'register'
            ? 'Kode OTP Verifikasi Registrasi — PT Katiga Veritas Indonesia'
            : 'Kode OTP Reset Password — PT Katiga Veritas Indonesia';

        return $this->subject($subject)
                    ->view('mail.otp');
    }
}
