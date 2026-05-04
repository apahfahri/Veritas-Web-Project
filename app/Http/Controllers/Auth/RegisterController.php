<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\KlienIndividu;
use App\Models\KlienPerusahaan;
use App\Models\OtpCode;
use App\Models\Perusahaan;
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
    | STEP 2 — Validasi form, simpan ke session, kirim OTP
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
            $rules['username'] = ['required', 'string', 'max:255'];
            $rules['nik']      = ['required', 'string', 'size:16'];
        } else {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['pic_name']     = ['required', 'string', 'max:255'];
        }

        $request->validate($rules);

        // Simpan semua data ke session (belum buat user)
        $request->session()->put('register_data', [
            'user_type'      => $type,
            'username'       => $type === 'individual' ? $request->username : $request->pic_name,
            'email'          => $request->email,
            'password'       => $request->password,
            // Individu
            'nik'            => $request->nik,
            'phone'          => $request->phone,
            // Perusahaan
            'company_name'   => $request->company_name,
            'alamat'         => $request->alamat,
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
        if (!session()->has('register_data')) {
            return redirect()->route('register')
                             ->with('error', 'Silakan isi form registrasi terlebih dahulu.');
        }

        return view('pages.otp-verify', [
            'email'   => session('register_data.email'),
            'type'    => 'register',
            'action'  => route('register.otp.verify'),
            'title'   => 'Verifikasi Email',
            'message' => 'Masukkan kode OTP 6 digit yang dikirim ke email Anda untuk menyelesaikan pendaftaran.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 — Verifikasi OTP → buat User + profil klien
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if (!session()->has('register_data')) {
            return redirect()->route('register')
                             ->with('error', 'Sesi registrasi telah berakhir. Silakan ulangi.');
        }

        $data  = session('register_data');
        $email = $data['email'];
        $otp   = $request->input('otp');

        if (!OtpCode::verify($email, 'register', $otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // ── Buat user utama ──────────────────────────────────────────────
        $user = User::create([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // ── Buat profil sesuai tipe ──────────────────────────────────────
        if ($data['user_type'] === 'individual') {

            KlienIndividu::create([
                'user_id'      => $user->id,
                'nik'          => $data['nik']   ?? null,
                'nama_lengkap' => $data['username'],
                'no_hp'        => $data['phone'] ?? null,
            ]);

        } else {

            // 1. Buat record Perusahaan
            $perusahaan = Perusahaan::create([
                'nama'             => $data['company_name'],
                'no_telp'          => $data['phone']          ?? null,
                'alamat'           => $data['alamat']         ?? null,
                'npwp_perusahaan'  => $data['npwp']           ?? null,
                'sektor_industri'  => $data['business_field'] ?? null,
            ]);

            // 2. Buat record KlienPerusahaan (PIC / contact person)
            KlienPerusahaan::create([
                'user_id'       => $user->id,
                'perusahaan_id' => $perusahaan->id,
                'nama_lengkap'  => $data['pic_name']      ?? $data['username'],
                'jabatan'       => $data['pic_position']  ?? null,
                'no_hp'         => $data['phone']          ?? null,
            ]);
        }

        // ── Bersihkan session & login ────────────────────────────────────
        session()->forget('register_data');
        Auth::login($user);

        return redirect('/dashboard')
                   ->with('success', 'Akun berhasil dibuat! Selamat datang di PT Katiga Veritas Indonesia.');
    }

    /*
    |--------------------------------------------------------------------------
    | Resend OTP
    |--------------------------------------------------------------------------
    */
    public function resendOtp()
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register')
                             ->with('error', 'Sesi registrasi telah berakhir.');
        }

        $email = session('register_data.email');
        $otp   = OtpCode::generate($email, 'register');
        Mail::to($email)->send(new OtpMail($otp, 'register'));

        return back()->with('info', 'Kode OTP baru telah dikirim ke ' . $email);
    }
}
