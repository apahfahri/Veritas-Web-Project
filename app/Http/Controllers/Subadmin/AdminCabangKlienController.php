<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\KlienIndividu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCabangKlienController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdminCabang()) {
                abort(403, 'Akses ditolak. Halaman khusus Admin Cabang.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $cabang = Auth::user()->admin?->cabang;
        $kliens = KlienIndividu::with('user')->where('cabang', $cabang)->latest()->paginate(15);

        return view('admin.admin-cabang.klien.index', compact('kliens'));
    }

    public function create()
    {
        // For new client, select user who has no client profile yet
        $users = User::whereDoesntHave('admin')
            ->whereDoesntHave('klienIndividu')
            ->whereDoesntHave('klienPerusahaan')
            ->get();

        return view('admin.admin-cabang.klien.create', compact('users'));
    }

    public function store(Request $request)
    {
        $cabang = Auth::user()->admin?->cabang;

        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'nik'          => 'nullable|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
        ]);

        KlienIndividu::create([
            'user_id'      => $request->user_id,
            'nik'          => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'cabang'       => $cabang,
        ]);

        return redirect()->route('admin-cabang.klien.index')
            ->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $klien = KlienIndividu::where('cabang', $cabang)->findOrFail($id);

        return view('admin.admin-cabang.klien.edit', compact('klien'));
    }

    public function update(Request $request, $id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $klien = KlienIndividu::where('cabang', $cabang)->findOrFail($id);

        $request->validate([
            'nik'          => 'nullable|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
        ]);

        $klien->update([
            'nik'          => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
        ]);

        return redirect()->route('admin-cabang.klien.index')
            ->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $klien = KlienIndividu::where('cabang', $cabang)->findOrFail($id);
        $klien->delete();

        return redirect()->route('admin-cabang.klien.index')
            ->with('success', 'Klien berhasil dihapus.');
    }
}
