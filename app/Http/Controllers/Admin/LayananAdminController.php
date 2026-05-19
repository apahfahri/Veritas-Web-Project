<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use App\Models\Pemateri;
use Illuminate\Http\Request;

class LayananAdminController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['kategori', 'jenis', 'pemateri'])->latest()->paginate(15);
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        return view('admin.jadwal.create', compact('kategoris', 'pemateris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'kode_jadwal'    => 'nullable|string|max:20',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'jam_pertemuan'  => 'nullable',
            'tanggal_usul'   => 'nullable|date',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'harga'          => 'required|numeric|min:0',
            'deskripsi'      => 'nullable|string',
            'pemateri_ids'   => 'nullable|array',
            'pemateri_ids.*' => 'exists:pemateri,id_pemateri',
        ]);

        $jadwal = Jadwal::create($request->only([
            'id_kategori', 'id_jenis', 'kode_jadwal', 'jenis_pertemuan',
            'jam_pertemuan', 'tanggal_usul', 'tgl_mulai', 'tgl_selesai',
            'lokasi', 'kapasitas', 'harga', 'deskripsi',
        ]));

        if ($request->filled('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal    = Jadwal::with('pemateri')->findOrFail($id);
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'kategoris', 'pemateris'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'kode_jadwal'    => 'nullable|string|max:20',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'jam_pertemuan'  => 'nullable',
            'tanggal_usul'   => 'nullable|date',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'harga'          => 'required|numeric|min:0',
            'deskripsi'      => 'nullable|string',
            'pemateri_ids'   => 'nullable|array',
            'pemateri_ids.*' => 'exists:pemateri,id_pemateri',
        ]);

        $jadwal->update($request->only([
            'id_kategori', 'id_jenis', 'kode_jadwal', 'jenis_pertemuan',
            'jam_pertemuan', 'tanggal_usul', 'tgl_mulai', 'tgl_selesai',
            'lokasi', 'kapasitas', 'harga', 'deskripsi',
        ]));

        if ($request->has('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        } else {
            $jadwal->pemateri()->detach();
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->pemateri()->detach();
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal layanan berhasil dihapus.');
    }
}
