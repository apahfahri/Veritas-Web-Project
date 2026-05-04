<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman login Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani callback dari Google setelah user login.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'email' => 'Login dengan Google gagal. Silakan coba lagi.',
            ]);
        }

        // Cari user berdasarkan google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // Cari berdasarkan email (mungkin sudah register manual)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update google_id untuk user yang sudah ada
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                ]);
            } else {
                // Buat user baru dari data Google
                $user = User::create([
                    'username'  => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'password'  => bcrypt(Str::random(40)), // password acak (tidak dipakai)
                ]);
            }
        }

        if ($user->isAdmin() && $user->admin->status === 'nonaktif') {
            return redirect('/login')->withErrors([
                'email' => 'Akun admin Anda telah dinonaktifkan.',
            ]);
        }

        Auth::login($user, true); // true = remember me

        return redirect('/dashboard');
    }
}
