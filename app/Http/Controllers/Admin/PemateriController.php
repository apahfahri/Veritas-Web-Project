<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemateri;
use Illuminate\Http\Request;

class PemateriController extends Controller
{
    public function index()
    {
        $pemateris = Pemateri::latest()->paginate(10);
        return view('admin.petugas.index', compact('pemateris'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kompetensi'   => 'nullable|string',
            'no_hp'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
        ]);

        Pemateri::create($request->all());

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pemateri = Pemateri::findOrFail($id);
        return view('admin.petugas.edit', compact('pemateri'));
    }

    public function update(Request $request, $id)
    {
        $pemateri = Pemateri::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kompetensi'   => 'nullable|string',
            'no_hp'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
        ]);

        $pemateri->update($request->all());

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemateri = Pemateri::findOrFail($id);
        $pemateri->layanan()->detach();
        $pemateri->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil dihapus.');
    }
}
