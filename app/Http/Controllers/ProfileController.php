<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\KlienPerusahaan;
use App\Models\Perusahaan;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function edit()
    {
        $user = Auth::user();
        $perusahaanProfil = $user->klienPerusahaan;
        $perusahaan = $perusahaanProfil ? $perusahaanProfil->perusahaan : null;

        return view('pages.profile', compact('user', 'perusahaanProfil', 'perusahaan'));
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|min:8|confirmed',
            // Validasi individu
            'nik' => 'nullable|string|max:16',
            'no_hp' => 'nullable|string|max:20',
            // Validasi perusahaan
            'nama_perusahaan' => 'nullable|string|max:255',
            'nib_oss' => 'nullable|string|max:50',
            'npwp_perusahaan' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
        ]);

        // Update User Dasar
        $user->nama = $request->name;
        $user->email = $request->email;
        if ($request->filled('no_hp')) {
            $user->no_telp = $request->no_hp;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();



        // Update Profil Perusahaan jika ada
        if ($user->klienPerusahaan) {
            $user->klienPerusahaan->update([
                'nama_lengkap' => $request->name,
                'jabatan' => $request->jabatan,
            ]);

            if ($user->klienPerusahaan->perusahaan) {
                $user->klienPerusahaan->perusahaan->update([
                    'nama' => $request->nama_perusahaan,
                    'nib_oss' => $request->nib_oss,
                    'npwp_perusahaan' => $request->npwp_perusahaan,
                ]);
            }
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
