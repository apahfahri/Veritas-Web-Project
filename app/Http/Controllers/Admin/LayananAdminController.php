<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\KategoriLayanan;
use App\Models\Pemateri;
use Illuminate\Http\Request;

class LayananAdminController extends Controller
{
    public function index()
    {
        $layanans = Layanan::with(['kategori', 'pemateri'])->latest()->paginate(10);
        return view('admin.pelatihan.index', compact('layanans'));
    }

    public function create()
    {
        $kategoris = KategoriLayanan::all();
        $pemateris = Pemateri::all();
        return view('admin.pelatihan.create', compact('kategoris', 'pemateris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'       => 'required|exists:kategori_layanan,id_kategori',
            'materi'            => 'required|string|max:255',
            'jenis_pertemuan'   => 'required|in:online,offline',
            'jam_pertemuan'     => 'nullable',
            'tanggal_pertemuan' => 'nullable|date',
            'lokasi'            => 'nullable|string|max:255',
            'kapasitas'         => 'nullable|integer|min:1',
            'deskripsi'         => 'nullable|string',
            'pemateri_ids'      => 'nullable|array',
            'pemateri_ids.*'    => 'exists:pemateri,id_pemateri',
        ]);

        $layanan = Layanan::create($request->only([
            'id_kategori', 'materi', 'jenis_pertemuan', 'jam_pertemuan', 
            'tanggal_pertemuan', 'lokasi', 'kapasitas', 'deskripsi'
        ]));

        if ($request->has('pemateri_ids')) {
            $layanan->pemateri()->sync($request->pemateri_ids);
        }

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $layanan = Layanan::with('pemateri')->findOrFail($id);
        $kategoris = KategoriLayanan::all();
        $pemateris = Pemateri::all();
        return view('admin.pelatihan.edit', compact('layanan', 'kategoris', 'pemateris'));
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $request->validate([
            'id_kategori'       => 'required|exists:kategori_layanan,id_kategori',
            'materi'            => 'required|string|max:255',
            'jenis_pertemuan'   => 'required|in:online,offline',
            'jam_pertemuan'     => 'nullable',
            'tanggal_pertemuan' => 'nullable|date',
            'lokasi'            => 'nullable|string|max:255',
            'kapasitas'         => 'nullable|integer|min:1',
            'deskripsi'         => 'nullable|string',
            'pemateri_ids'      => 'nullable|array',
            'pemateri_ids.*'    => 'exists:pemateri,id_pemateri',
        ]);

        $layanan->update($request->only([
            'id_kategori', 'materi', 'jenis_pertemuan', 'jam_pertemuan', 
            'tanggal_pertemuan', 'lokasi', 'kapasitas', 'deskripsi'
        ]));

        if ($request->has('pemateri_ids')) {
            $layanan->pemateri()->sync($request->pemateri_ids);
        } else {
            $layanan->pemateri()->detach();
        }

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->pemateri()->detach();
        $layanan->delete();

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
