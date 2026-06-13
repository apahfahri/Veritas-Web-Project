<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Verifikasi;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        return view('pages.verification');
    }

    public function cek(Request $request)
    {
        $request->validate(['no_sertifikat' => 'required|string|max:100']);

        $sertifikat = Sertifikat::with(['pendaftaran.jadwal.jenis', 'pendaftaran.user'])
            ->where('no_sertifikat', trim(strtoupper($request->no_sertifikat)))
            ->first();

        $status = $sertifikat ? 'valid' : 'tidak_ditemukan';

        Verifikasi::create([
            'no_sertifikat' => $request->no_sertifikat,
            'sertifikat_no' => $sertifikat?->no_sertifikat,
            'status'        => $status,
            'ip_address'    => $request->ip(),
        ]);

        return view('pages.verification', compact('sertifikat', 'status'));
    }

    public function downloadPdf($no_sertifikat)
    {
        $sertifikat = Sertifikat::with(['pendaftaran.jadwal.jenis'])->findOrFail($no_sertifikat);

        // Always render the premium certificate template dynamically
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.certificate_template', compact('sertifikat'))
            ->setPaper('a4', 'landscape')
            ->setOption(['isRemoteEnabled' => true, 'chroot' => public_path()]);

        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="sertifikat-' . $sertifikat->no_sertifikat . '.pdf"',
        ]);
    }
}
