<?php

namespace App\Http\Controllers;

use App\Models\RequestPelatihan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class RequestPelatihanController extends Controller
{
    public function create()
    {
        $jenisLayanan = JenisLayanan::where('id_kategori', 1)->orderBy('nama', 'asc')->get();
        return view('pages.request-training', compact('jenisLayanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:20',
            'nama_perusahaan' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_peserta' => 'nullable|integer|min:1',
            'topik_pelatihan' => 'required|string|max:255',
            'tanggal_harapan' => 'nullable|date',
            'pesan_tambahan' => 'nullable|string',
        ]);

        $data = $validated;
        $data['jumlah_karyawan'] = $data['jumlah_peserta'] ?? null;
        unset($data['jumlah_peserta']);

        RequestPelatihan::create($data);

        return redirect()->route('training.list')->with('success', 'Request pelatihan berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}
