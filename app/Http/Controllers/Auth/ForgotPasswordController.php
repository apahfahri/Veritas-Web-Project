<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1 — Tampilkan form input email
    |--------------------------------------------------------------------------
    */
    public function showForm()
    {
        return view('pages.forgot-password');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2 — Validasi email & kirim OTP
    |--------------------------------------------------------------------------
    */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak ditemukan dalam sistem kami.',
        ]);

        $otp = OtpCode::generate($request->email, 'forgot_password');
        Mail::to($request->email)->send(new OtpMail($otp, 'forgot_password'));

        // Simpan email ke session
        session()->put('fp_email', $request->email);

        return redirect()->route('password.otp')
                         ->with('info', 'Kode OTP telah dikirim ke ' . $request->email);
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 — Tampilkan form input OTP
    |--------------------------------------------------------------------------
    */
    public function showOtpForm()
    {
        if (!session()->has('fp_email')) {
            return redirect()->route('password.request')->with('error', 'Silakan masukkan email Anda terlebih dahulu.');
        }

        $email = session('fp_email');
        return view('pages.otp-verify', [
            'email'   => $email,
            'type'    => 'forgot_password',
            'action'  => route('password.otp.verify'),
            'title'   => 'Verifikasi Reset Password',
            'message' => 'Masukkan kode OTP 6 digit yang telah dikirim ke email Anda untuk mereset password.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 — Verifikasi OTP, simpan flag ke session, redirect ke reset form
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if (!session()->has('fp_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi telah berakhir. Silakan ulangi.');
        }

        $email = session('fp_email');
        $otp   = implode('', $request->input('otp_digit', [])) ?: $request->input('otp');

        if (!OtpCode::verify($email, 'forgot_password', $otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // Tandai bahwa OTP sudah diverifikasi
        session()->put('fp_verified', true);

        return redirect()->route('password.reset.form');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 5 — Tampilkan form reset password baru
    |--------------------------------------------------------------------------
    */
    public function showResetForm()
    {
        if (!session()->has('fp_email') || !session('fp_verified')) {
            return redirect()->route('password.request')->with('error', 'Akses tidak valid. Silakan ulangi proses.');
        }

        return view('pages.reset-password', [
            'email' => session('fp_email'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 6 — Update password & login
    |--------------------------------------------------------------------------
    */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!session()->has('fp_email') || !session('fp_verified')) {
            return redirect()->route('password.request')->with('error', 'Sesi tidak valid. Silakan ulangi proses.');
        }

        $email = session('fp_email');
        $user  = User::where('email', $email)->firstOrFail();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Bersihkan session
        session()->forget(['fp_email', 'fp_verified']);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Password berhasil direset! Selamat datang kembali.');
    }

    /*
    |--------------------------------------------------------------------------
    | Resend OTP (forgot password)
    |--------------------------------------------------------------------------
    */
    public function resendOtp(Request $request)
    {
        if (!session()->has('fp_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi telah berakhir.');
        }

        $email = session('fp_email');
        $otp   = OtpCode::generate($email, 'forgot_password');
        Mail::to($email)->send(new OtpMail($otp, 'forgot_password'));

        return back()->with('info', 'Kode OTP baru telah dikirim ke ' . $email);
    }
}
