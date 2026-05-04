<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP — PT Katiga Veritas Indonesia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6fb; color: #1a2236; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0A2540 0%, #00A8A8 100%); padding: 36px 32px; text-align: center; }
        .header-icon { font-size: 48px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: 0.3px; }
        .header p { color: rgba(255,255,255,0.75); font-size: 13px; margin-top: 4px; }
        .body { padding: 36px 32px; }
        .body p { font-size: 14px; color: #4b5563; line-height: 1.7; }
        .otp-box { background: #f0fdfc; border: 2px dashed #00A8A8; border-radius: 12px; text-align: center; padding: 24px 16px; margin: 24px 0; }
        .otp-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: #00A8A8; margin-bottom: 8px; }
        .otp-code { font-size: 44px; font-weight: 800; letter-spacing: 12px; color: #0A2540; font-family: 'Courier New', monospace; }
        .otp-expiry { font-size: 12px; color: #9ca3af; margin-top: 8px; }
        .warning { background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 6px; padding: 12px 16px; margin-top: 20px; font-size: 13px; color: #92400e; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 32px; text-align: center; }
        .footer p { font-size: 12px; color: #9ca3af; line-height: 1.6; }
        .footer strong { color: #0A2540; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-icon">🛡️</div>
        <h1>PT Katiga Veritas Indonesia</h1>
        <p>
            @if($type === 'register')
                Verifikasi Registrasi Akun
            @else
                Reset Password Akun
            @endif
        </p>
    </div>

    {{-- BODY --}}
    <div class="body">

        <p>Halo,</p>
        <br>

        @if($type === 'register')
            <p>Terima kasih telah mendaftar di platform <strong>PT Katiga Veritas Indonesia</strong>. Gunakan kode OTP di bawah ini untuk menyelesaikan proses verifikasi akun Anda:</p>
        @else
            <p>Kami menerima permintaan reset password untuk akun Anda di <strong>PT Katiga Veritas Indonesia</strong>. Gunakan kode OTP di bawah ini untuk melanjutkan proses reset password:</p>
        @endif

        {{-- OTP BOX --}}
        <div class="otp-box">
            <div class="otp-label">Kode OTP Anda</div>
            <div class="otp-code">{{ $otp }}</div>
            <div class="otp-expiry">⏱ Berlaku selama <strong>{{ $expiry }}</strong> sejak email ini dikirim</div>
        </div>

        <div class="warning">
            ⚠️ <strong>Jangan bagikan kode ini kepada siapapun</strong>, termasuk tim PT Katiga Veritas Indonesia. Kami tidak pernah meminta kode OTP Anda.
        </div>

        <br>
        <p>Jika Anda tidak melakukan tindakan ini, abaikan email ini. Akun Anda tetap aman.</p>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem <strong>PT Katiga Veritas Indonesia</strong>.<br>
        Harap tidak membalas email ini.</p>
        <br>
        <p style="color:#d1d5db;">© {{ date('Y') }} PT Katiga Veritas Indonesia. All rights reserved.</p>
    </div>

</div>
</body>
</html>
