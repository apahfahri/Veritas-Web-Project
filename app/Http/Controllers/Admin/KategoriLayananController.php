<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class KategoriLayananController extends Controller
{
    public function index()
    {
        $kategoris = KategoriLayanan::with('jenis')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // ─── Kategori CRUD ───────────────────────────────────────

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'kode_kategori'  => 'required|string|max:10|unique:kategori_layanan,kode_kategori',
            'deskripsi'      => 'nullable|string',
        ]);

        KategoriLayanan::create($request->only(['nama', 'kode_kategori', 'deskripsi']));

        return back()->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = KategoriLayanan::findOrFail($id);

        $request->validate([
            'nama'           => 'required|string|max:100',
            'kode_kategori'  => 'required|string|max:10|unique:kategori_layanan,kode_kategori,' . $id . ',id_kategori',
            'deskripsi'      => 'nullable|string',
        ]);

        $kategori->update($request->only(['nama', 'kode_kategori', 'deskripsi']));

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori($id)
    {
        $kategori = KategoriLayanan::findOrFail($id);
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // ─── Jenis Layanan CRUD ──────────────────────────────────

    public function storeJenis(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_layanan,id_kategori',
            'nama'        => 'required|string|max:255',
            'kode_jenis'  => 'nullable|string|max:15',
        ]);

        JenisLayanan::create($request->only(['id_kategori', 'nama', 'kode_jenis']));

        return back()->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function updateJenis(Request $request, $id)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'kode_jenis' => 'nullable|string|max:15',
        ]);

        $jenis = JenisLayanan::findOrFail($id);
        $jenis->update($request->only(['nama', 'kode_jenis']));

        return back()->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroyJenis($id)
    {
        $jenis = JenisLayanan::findOrFail($id);
        $jenis->delete();

        return back()->with('success', 'Jenis layanan berhasil dihapus.');
    }
}
