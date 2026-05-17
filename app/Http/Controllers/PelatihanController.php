<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::with('kategori')->whereHas('kategori', function ($q) {
            $q->where('nama', 'like', '%Pelatihan%');
        })->orderBy('tanggal_usul');

        if ($request->filled('jenis')) {
            $query->where('jenis_pertemuan', $request->jenis);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('materi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $pelatihans = $query->get();
        return view('pages.training-list', compact('pelatihans'));
    }

    public function show($id)
    {
        $pelatihan = Layanan::with(['kategori', 'pemateri'])->findOrFail($id);
        
        // Count pendaftaran to get sisa kursi
        $terdaftar = $pelatihan->pendaftaran()->count();
        $sisaKursi = $pelatihan->kapasitas ? max(0, $pelatihan->kapasitas - $terdaftar) : null;
        
        $related = Layanan::whereHas('kategori', function ($q) {
            $q->where('nama', 'like', '%Pelatihan%');
        })->where('id_layanan', '!=', $id)->take(3)->get();
        
        return view('pages.training-detail', compact('pelatihan', 'sisaKursi', 'related'));
    }

    public function register($id)
    {
        $pelatihan = Layanan::with('kategori')->findOrFail($id);
        return view('pages.training-register', compact('pelatihan'));
    }
}
