<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kategori', 'jenis'])->whereHas('kategori', function ($q) {
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
                $q->whereHas('jenis', function ($j) use ($search) {
                    $j->where('nama', 'like', "%{$search}%");
                })->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $jadwals = $query->get();
        return view('pages.training-list', compact('jadwals'));
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['kategori', 'pemateri', 'jenis'])->findOrFail($id);
        
        // Count pendaftaran to get sisa kursi (Hanya hitung yang terkonfirmasi & lunas)
        $sisaKursi = $jadwal->sisa_kursi;
        
        $related = Jadwal::with(['kategori', 'jenis'])->whereHas('kategori', function ($q) {
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
