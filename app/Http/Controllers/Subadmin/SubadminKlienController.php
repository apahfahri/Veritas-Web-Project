<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KlienIndividu;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminKlienController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $kliens = KlienIndividu::with('perusahaan')->latest()->paginate(15);
        return view('subadmin.klien.index', compact('kliens'));
    }

    public function create()
    {
        $users = User::all();
        $perusahaans = Perusahaan::all();
        return view('subadmin.klien.create', compact('users', 'perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id_user',
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'nullable|string|max:16',
            'no_hp'         => 'nullable|string|max:20',
            'id_perusahaan' => 'nullable|exists:perusahaan,id_perusahaan',
            'jabatan'       => 'nullable|string|max:100',
        ]);

        KlienIndividu::create([
            'user_id'       => $request->user_id,
            'nama_lengkap'  => $request->nama_lengkap,
            'nik'           => $request->nik,
            'no_hp'         => $request->no_hp,
            'id_perusahaan' => $request->id_perusahaan,
            'jabatan'       => $request->jabatan,
            'cabang'        => Auth::user()->admin?->cabang ?? 'pusat',
        ]);

        return redirect()->route('subadmin.klien.index')
            ->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $klien = KlienIndividu::findOrFail($id);
        $users = User::all();
        $perusahaans = Perusahaan::all();
        return view('subadmin.klien.edit', compact('klien', 'users', 'perusahaans'));
    }

    public function update(Request $request, $id)
    {
        $klien = KlienIndividu::findOrFail($id);

        $request->validate([
            'user_id'       => 'required|exists:users,id_user',
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'nullable|string|max:16',
            'no_hp'         => 'nullable|string|max:20',
            'id_perusahaan' => 'nullable|exists:perusahaan,id_perusahaan',
            'jabatan'       => 'nullable|string|max:100',
        ]);

        $klien->update($request->all());

        return redirect()->route('subadmin.klien.index')
            ->with('success', 'Data klien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $klien = KlienIndividu::findOrFail($id);
        $klien->delete();

        return redirect()->route('subadmin.klien.index')
            ->with('success', 'Data klien berhasil dihapus.');
    }
}

