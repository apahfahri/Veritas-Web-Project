<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminJadwalController extends Controller
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
        $jadwals = Jadwal::with('layanan')->latest()->paginate(15);
        return view('subadmin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        return view('subadmin.jadwal.create', compact('layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_layanan'   => 'required|exists:layanan,id_layanan',
            'tanggal'      => 'required|date',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required',
            'lokasi'       => 'required|string',
            'kuota'        => 'required|integer|min:1',
        ]);

        Jadwal::create([
            'id_layanan'   => $request->id_layanan,
            'tanggal'      => $request->tanggal,
            'jam_mulai'    => $request->jam_mulai,
            'jam_selesai'  => $request->jam_selesai,
            'lokasi'       => $request->lokasi,
            'kuota'        => $request->kuota,
            'cabang'       => Auth::user()->admin?->cabang ?? 'pusat',
            'status'       => 'aktif',
        ]);

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $layanans = Layanan::all();
        return view('subadmin.jadwal.edit', compact('jadwal', 'layanans'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'id_layanan'   => 'required|exists:layanan,id_layanan',
            'tanggal'      => 'required|date',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required',
            'lokasi'       => 'required|string',
            'kuota'        => 'required|integer|min:1',
            'status'       => 'required|in:aktif,penuh,selesai,batal',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}

