<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanAdminController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::with('layanan')->latest()->paginate(10);
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        return view('admin.pelatihan.create', compact('layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id'        => 'required|exists:layanan,id',
            'materi'            => 'required|string|max:255',
            'jenis_pertemuan'   => 'required|in:online,offline',
            'jam_pertemuan'     => 'nullable|date_format:H:i',
            'tanggal_pertemuan' => 'nullable|date',
            'lokasi'            => 'nullable|string|max:255',
            'kapasitas'         => 'nullable|integer|min:1',
            'deskripsi'         => 'nullable|string',
        ]);

        Pelatihan::create($request->all());

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $layanans  = Layanan::all();
        return view('admin.pelatihan.edit', compact('pelatihan', 'layanans'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $request->validate([
            'layanan_id'        => 'required|exists:layanan,id',
            'materi'            => 'required|string|max:255',
            'jenis_pertemuan'   => 'required|in:online,offline',
            'jam_pertemuan'     => 'nullable|date_format:H:i',
            'tanggal_pertemuan' => 'nullable|date',
            'lokasi'            => 'nullable|string|max:255',
            'kapasitas'         => 'nullable|integer|min:1',
            'deskripsi'         => 'nullable|string',
        ]);

        $pelatihan->update($request->all());

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pelatihan::findOrFail($id)->delete();
        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil dihapus.');
    }
}
