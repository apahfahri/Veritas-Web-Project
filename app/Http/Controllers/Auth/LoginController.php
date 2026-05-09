<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman form login.
     */
    public function showForm()
    {
        return view('pages.login');
    }

    /**
     * Proses login dengan email/username & password.
     * Subadmin bisa login menggunakan username atau email.
     * Superadmin login menggunakan email.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginInput = $request->input('login');
        $password   = $request->input('password');
        $remember   = $request->boolean('remember_me');

        // Cek apakah input berupa email atau username
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            // Login dengan email (semua role)
            $credentials = ['email' => $loginInput, 'password' => $password];

            if (Auth::attempt($credentials, $remember)) {
                return $this->handleAuthenticatedUser($request);
            }
        } else {
            // Login dengan username — cari admin berdasarkan username
            $admin = Admin::where('username', $loginInput)->first();

            if ($admin && Hash::check($password, $admin->password)) {
                Auth::login($admin, $remember);
                return $this->handleAuthenticatedUser($request);
            }
        }

        return back()->withErrors([
            'login' => 'Username/email atau password tidak cocok.',
        ])->onlyInput('login');
    }

    /**
     * Tangani user yang sudah berhasil login.
     */
    private function handleAuthenticatedUser(Request $request)
    {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->status === 'nonaktif') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors([
                'login' => 'Akun Anda telah dinonaktifkan.',
            ])->onlyInput('login');
        }

        if ($user->isSubadmin()) {
            return redirect('/subadmin/dashboard');
        }

        if ($user->isSuperAdmin()) {
            return redirect('/admin');
        }

        return redirect('/');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
