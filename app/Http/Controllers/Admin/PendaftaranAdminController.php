<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PendaftaranAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'layanan', 'petugas'])->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }
        if ($request->filled('bayar')) {
            $query->where('status_bayar', $request->bayar);
        }

        $pendaftarans = $query->paginate(15);
        $petugas      = Petugas::all();

        return view('admin.pendaftaran.index', compact('pendaftarans', 'petugas'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'layanan', 'petugas', 'sertifikat'])->findOrFail($id);
        $petugas     = Petugas::all();
        return view('admin.pendaftaran.show', compact('pendaftaran', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $request->validate([
            'status_progres' => 'required|in:menunggu,diproses,selesai,dibatalkan',
            'status_bayar'   => 'required|in:belum_bayar,menunggu_konfirmasi,lunas',
            'petugas_id'     => 'nullable|exists:petugas,id',
        ]);

        $pendaftaran->update($request->only('status_progres', 'status_bayar', 'petugas_id'));

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
