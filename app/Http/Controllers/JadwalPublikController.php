<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman publik daftar & detail jadwal layanan (Pelatihan, Konsultasi, Audit)
 */
class JadwalPublikController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kategori', 'jenis', 'pemateri'])
            ->whereHas('kategori', function ($q) {
                $q->where('nama', 'like', '%Pelatihan%');
            })
            ->whereDoesntHave('pendaftarans', function ($q) {
                $q->where('is_kustom', true);
            })
            ->whereDate('tgl_mulai', '>', now()->addDays(3))
            ->orderBy('tgl_mulai');

        if ($request->filled('jenis')) {
            $query->where('jenis_pertemuan', $request->jenis);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('jenis', function ($qJ) use ($search) {
                    $qJ->where('nama', 'like', "%{$search}%");
                })->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $jadwals = $query->paginate(6)->withQueryString();
        return view('pages.training-list', compact('jadwals'));
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['kategori', 'jenis', 'pemateri'])->findOrFail($id);
        $sisaKursi = $jadwal->sisa_kursi;

        $related = Jadwal::whereHas('kategori', function ($q) {
            $q->where('nama', 'like', '%Pelatihan%');
        })
        ->whereDoesntHave('pendaftarans', function ($q) {
            $q->where('is_kustom', true);
        })
        ->where('id_jadwal', '!=', $id)
        ->whereDate('tgl_mulai', '>', now()->addDays(3))
        ->take(3)->get();

        return view('pages.training-detail', compact('jadwal', 'sisaKursi', 'related'));
    }

    public function register($id)
    {
        $jadwal = Jadwal::with(['kategori', 'jenis'])->findOrFail($id);
        return view('pages.training-register', compact('jadwal'));
    }
}
