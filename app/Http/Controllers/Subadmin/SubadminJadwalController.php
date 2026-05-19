<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use App\Models\Pemateri;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminJadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Jadwal::with(['kategori', 'jenis', 'pemateri'])
            ->withCount(['pendaftarans as pending_count' => function ($q) {
                $q->where('status_progres', 'menunggu');
            }]);

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        if ($request->filled('jenis_pertemuan')) {
            $query->where('jenis_pertemuan', $request->jenis_pertemuan);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jenis', fn($q) => $q->where('nama', 'like', "%{$search}%"));
        }

        $jadwals   = $query->latest()->paginate(15);
        $kategoris = KategoriLayanan::all();

        return view('subadmin.jadwal.index', compact('jadwals', 'kategoris'));
    }

    public function show($id)
    {
        $jadwal   = Jadwal::with(['kategori', 'jenis', 'pemateri'])->findOrFail($id);
        $pesertas = Pendaftaran::where('id_jadwal', $id)
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('subadmin.jadwal.show', compact('jadwal', 'pesertas'));
    }

    public function create()
    {
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        return view('subadmin.jadwal.create', compact('kategoris', 'pemateris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'kode_jadwal'    => 'nullable|string|max:20',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
            'jam_pertemuan'  => 'nullable',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'harga'          => 'required|numeric|min:0',
            'deskripsi'      => 'nullable|string',
            'pemateri_ids'   => 'nullable|array',
            'pemateri_ids.*' => 'exists:pemateri,id_pemateri',
        ]);

        $jadwal = Jadwal::create($request->only([
            'id_kategori', 'id_jenis', 'kode_jadwal', 'jenis_pertemuan',
            'tgl_mulai', 'tgl_selesai', 'jam_pertemuan', 'lokasi',
            'kapasitas', 'harga', 'deskripsi',
        ]));

        if ($request->filled('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        }

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal    = Jadwal::with('pemateri')->findOrFail($id);
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        return view('subadmin.jadwal.edit', compact('jadwal', 'kategoris', 'pemateris'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'kode_jadwal'    => 'nullable|string|max:20',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
            'jam_pertemuan'  => 'nullable',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'harga'          => 'required|numeric|min:0',
            'deskripsi'      => 'nullable|string',
            'pemateri_ids'   => 'nullable|array',
            'pemateri_ids.*' => 'exists:pemateri,id_pemateri',
        ]);

        $jadwal->update($request->only([
            'id_kategori', 'id_jenis', 'kode_jadwal', 'jenis_pertemuan',
            'tgl_mulai', 'tgl_selesai', 'jam_pertemuan', 'lokasi',
            'kapasitas', 'harga', 'deskripsi',
        ]));

        if ($request->has('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        } else {
            $jadwal->pemateri()->detach();
        }

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->pemateri()->detach();
        $jadwal->delete();

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
