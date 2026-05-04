<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'layanan'])->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }
        if ($request->filled('bayar')) {
            $query->where('status_bayar', $request->bayar);
        }

        $pendaftarans = $query->paginate(15);

        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'layanan', 'sertifikat'])->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $request->validate([
            'status_progres' => 'required|in:menunggu,diproses,selesai,dibatalkan',
            'status_bayar'   => 'required|in:belum_bayar,menunggu_konfirmasi,lunas',
        ]);

        $pendaftaran->update($request->only('status_progres', 'status_bayar'));

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}

