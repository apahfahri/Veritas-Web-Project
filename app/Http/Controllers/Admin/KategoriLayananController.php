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

    public function storeJenis(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_layanan,id_kategori',
            'nama' => 'required|string|max:255',
        ]);

        JenisLayanan::create($request->all());

        return back()->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function updateJenis(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $jenis = JenisLayanan::findOrFail($id);
        $jenis->update($request->all());

        return back()->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroyJenis($id)
    {
        $jenis = JenisLayanan::findOrFail($id);
        $jenis->delete();

        return back()->with('success', 'Jenis layanan berhasil dihapus.');
    }
}
