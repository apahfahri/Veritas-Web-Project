<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id'     => 'required|exists:layanan,id',
            'tanggal_daftar' => 'required|date|after_or_equal:today',
        ]);

        Pendaftaran::create([
            'layanan_id'     => $request->layanan_id,
            'user_id'        => Auth::id(),
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_progres' => 'menunggu',
            'status_bayar'   => 'belum_bayar',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);

        if ($pendaftaran->status_progres !== 'menunggu') {
            return back()->with('error', 'Pendaftaran tidak dapat dibatalkan karena sudah diproses.');
        }

        $pendaftaran->update(['status_progres' => 'dibatalkan']);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
