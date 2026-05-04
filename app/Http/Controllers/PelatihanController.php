<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelatihan::with('layanan')->orderBy('tanggal_pertemuan');

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
        $pelatihan = Pelatihan::with('layanan')->findOrFail($id);
        $sisaKursi = $pelatihan->kapasitas;
        $related   = Pelatihan::where('id', '!=', $id)->take(3)->get();
        return view('pages.training-detail', compact('pelatihan', 'sisaKursi', 'related'));
    }

    public function register($id)
    {
        $pelatihan = Pelatihan::with('layanan')->findOrFail($id);
        return view('pages.training-register', compact('pelatihan'));
    }
}
