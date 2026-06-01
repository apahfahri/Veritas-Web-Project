<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $materis = Materi::latest()->paginate(5);
        return view('admin.materi.index', compact('materis'));
    }

    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_materi' => 'required|file|mimes:pdf|max:10240', // max 10MB
            'deskripsi' => 'nullable|string'
        ]);

        $path = $request->file('file_materi')->store('materi', 'public');

        Materi::create([
            'judul' => $request->judul,
            'file_path' => $path,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_materi' => 'nullable|file|mimes:pdf|max:10240',
            'deskripsi' => 'nullable|string'
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if ($request->hasFile('file_materi')) {
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $data['file_path'] = $request->file('file_materi')->store('materi', 'public');
        }

        $materi->update($data);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }
        $materi->delete();

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
