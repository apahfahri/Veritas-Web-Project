<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatAdminController extends Controller
{
    public function index()
    {
        $sertifikats = Sertifikat::with('pendaftaran.user')->latest()->paginate(15);
        return view('admin.sertifikat.index', compact('sertifikats'));
    }

    public function create($pendaftaran_id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'layanan'])->findOrFail($pendaftaran_id);

        // Pastikan belum ada sertifikat untuk pendaftaran ini
        if ($pendaftaran->sertifikat) {
            return redirect()->route('admin.sertifikat.index')
                ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
        }

        return view('admin.sertifikat.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        $noSertifikat = $this->generateNoSertifikat();

        Sertifikat::create([
            'no_sertifikat'  => $noSertifikat,
            'pendaftaran_id' => $request->pendaftaran_id,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        // Update status pendaftaran menjadi selesai
        Pendaftaran::find($request->pendaftaran_id)
            ->update(['status_progres' => 'selesai']);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Sertifikat {$noSertifikat} berhasil diterbitkan.");
    }

    private function generateNoSertifikat(): string
    {
        $year  = date('Y');
        $count = Sertifikat::whereYear('created_at', $year)->count() + 1;
        return sprintf('KV-K3-%s-%06d', $year, $count);
    }
}
