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
    public function index(Request $request)
    {
        $query = Jadwal::with(['kategori', 'jenis', 'pemateri']);
        
        $filter = $request->input('filter', 'akan_datang');

        if ($filter === 'akan_datang') {
            $query->where(function ($q) {
                $q->whereDate('tgl_mulai', '>=', now())
                  ->orWhereDate('tgl_selesai', '>=', now())
                  ->orWhereNull('tgl_mulai');
            });
        } elseif ($filter === 'riwayat') {
            $query->where(function ($q) {
                $q->whereDate('tgl_mulai', '<', now())
                  ->where(function ($sub) {
                      $sub->whereDate('tgl_selesai', '<', now())
                          ->orWhereNull('tgl_selesai');
                  });
            });
        }

        $jadwals = $query->latest()->paginate(15)->appends(['filter' => $filter]);
        return view('admin.jadwal.index', compact('jadwals', 'filter'));
    }

    public function create()
    {
        $kategoris = KategoriLayanan::where('nama', 'like', '%Pelatihan%')->with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        return view('admin.jadwal.create', compact('kategoris', 'pemateris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
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

        $kategori = KategoriLayanan::findOrFail($request->id_kategori);
        $jenis = JenisLayanan::findOrFail($request->id_jenis);
        $urutan = Jadwal::where('id_jenis', $request->id_jenis)->count() + 1;
        $urutanFormat = str_pad($urutan, 2, '0', STR_PAD_LEFT);
        $kode_jadwal = "{$kategori->kode_kategori}-{$jenis->kode_jenis}-{$urutanFormat}";

        // Aturan Bisnis: Ahli K3 Umum 13 hari, lainnya 5 hari (jika tgl_selesai kosong dan tgl_mulai ada)
        $tgl_selesai = $request->tgl_selesai;
        if ($request->tgl_mulai && empty($tgl_selesai)) {
            $isK3Umum = stripos($jenis->nama, 'Ahli K3 Umum') !== false;
            $days = $isK3Umum ? 12 : 4; // 13 hari atau 5 hari inklusif (tambah 12 atau 4 hari dari mulai)
            $tgl_selesai = \Carbon\Carbon::parse($request->tgl_mulai)->addDays($days)->format('Y-m-d');
        }

        $jadwal = Jadwal::create(array_merge($request->only([
            'id_kategori', 'id_jenis', 'jenis_pertemuan',
            'jam_pertemuan', 'tanggal_usul', 'tgl_mulai',
            'lokasi', 'kapasitas', 'harga', 'deskripsi',
        ]), [
            'kode_jadwal' => $kode_jadwal,
            'tgl_selesai' => $tgl_selesai
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

        // Aturan Bisnis: Ahli K3 Umum 13 hari, lainnya 5 hari (jika tgl_selesai kosong dan tgl_mulai ada)
        $tgl_selesai = $request->tgl_selesai;
        if ($request->tgl_mulai && empty($tgl_selesai)) {
            $jenis = JenisLayanan::find($request->id_jenis);
            if ($jenis) {
                $isK3Umum = stripos($jenis->nama, 'Ahli K3 Umum') !== false;
                $days = $isK3Umum ? 12 : 4; // 13 hari atau 5 hari inklusif
                $tgl_selesai = \Carbon\Carbon::parse($request->tgl_mulai)->addDays($days)->format('Y-m-d');
            }
        }

        $jadwal->update(array_merge($request->only([
            'id_kategori', 'id_jenis', 'kode_jadwal', 'jenis_pertemuan',
            'jam_pertemuan', 'tanggal_usul', 'tgl_mulai',
            'lokasi', 'kapasitas', 'harga', 'deskripsi',
        ]), ['tgl_selesai' => $tgl_selesai]));

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
