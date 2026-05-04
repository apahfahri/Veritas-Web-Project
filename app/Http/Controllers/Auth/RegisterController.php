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

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1 — Tampilkan form register
    |--------------------------------------------------------------------------
    */
    public function showForm()
    {
        return view('pages.register');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2 — Validasi form, simpan ke session, kirim OTP, redirect ke OTP
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $type = $request->input('user_type', 'individual');

        // Validasi umum
        $rules = [
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Validasi tambahan per tipe
        if ($type === 'individual') {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['nik']  = ['required', 'string', 'size:16'];
        } else {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['pic_name']     = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        // Simpan semua data form ke session (sementara, belum buat user)
        $request->session()->put('register_data', [
            'user_type'      => $type,
            'name'           => $type === 'individual' ? $request->name : $request->pic_name,
            'email'          => $request->email,
            'password'       => $request->password,
            'nik'            => $request->nik,
            'phone'          => $request->phone,
            'company_name'   => $request->company_name,
            'npwp'           => $request->npwp,
            'business_field' => $request->business_field,
            'pic_name'       => $request->pic_name,
            'pic_position'   => $request->pic_position,
        ]);

        // Generate OTP & kirim email
        $otp = OtpCode::generate($request->email, 'register');

        Mail::to($request->email)->send(new OtpMail($otp, 'register'));

        return redirect()->route('register.otp')
                         ->with('info', 'Kode OTP telah dikirim ke ' . $request->email);
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 — Tampilkan halaman input OTP
    |--------------------------------------------------------------------------
    */
    public function showOtp()
    {
        // Jika tidak ada data registrasi di session, kembali ke form
        if (!session()->has('register_data')) {
            return redirect()->route('register')->with('error', 'Silakan isi form registrasi terlebih dahulu.');
        }

        $email = session('register_data.email');
        return view('pages.otp-verify', [
            'email'   => $email,
            'type'    => 'register',
            'action'  => route('register.otp.verify'),
            'title'   => 'Verifikasi Email',
            'message' => 'Masukkan kode OTP 6 digit yang telah dikirim ke email Anda untuk menyelesaikan pendaftaran.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 — Verifikasi OTP & buat akun
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if (!session()->has('register_data')) {
            return redirect()->route('register')->with('error', 'Sesi registrasi telah berakhir. Silakan ulangi.');
        }

        $data  = session('register_data');
        $email = $data['email'];
        $otp   = implode('', $request->input('otp_digit', [])) ?: $request->input('otp');

        if (!OtpCode::verify($email, 'register', $otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // Buat user
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Bersihkan session
        session()->forget('register_data');

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang.');
    }

    /*
    |--------------------------------------------------------------------------
    | Resend OTP
    |--------------------------------------------------------------------------
    */
    public function resendOtp(Request $request)
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register')->with('error', 'Sesi registrasi telah berakhir.');
        }

        $email = session('register_data.email');
        $otp   = OtpCode::generate($email, 'register');
        Mail::to($email)->send(new OtpMail($otp, 'register'));

        return back()->with('info', 'Kode OTP baru telah dikirim ke ' . $email);
    }
}
