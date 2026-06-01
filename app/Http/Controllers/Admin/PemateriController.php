<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PemateriController extends Controller
{
    public function index()
    {
        $pemateris = Pemateri::with(['jadwals.jenis', 'jadwals.kategori'])->latest()->paginate(5);
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
            'bio'          => 'nullable|string',
            'no_telp'      => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::slug($request->nama_lengkap) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pemateri', $filename, 'public');
            $data['foto'] = $path;
        }

        Pemateri::create($data);

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
            'bio'          => 'nullable|string',
            'no_telp'      => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pemateri->foto) {
                Storage::disk('public')->delete($pemateri->foto);
            }

            $file = $request->file('foto');
            $filename = Str::slug($request->nama_lengkap) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pemateri', $filename, 'public');
            $data['foto'] = $path;
        }

        $pemateri->update($data);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemateri = Pemateri::findOrFail($id);
        
        // Hapus foto jika ada
        if ($pemateri->foto) {
            Storage::disk('public')->delete($pemateri->foto);
        }

        $pemateri->jadwals()->detach();
        $pemateri->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil dihapus.');
    }
}
