<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlienPerusahaan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlienMitraController extends Controller
{
    /**
     * Daftar seluruh mitra perusahaan.
     */
    public function index(Request $request)
    {
        $query = Perusahaan::with(['klienPerusahaan.user'])->latest('id_perusahaan');

        // Search berdasarkan nama perusahaan atau nama CP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('klienPerusahaan.user', function ($u) use ($search) {
                      $u->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('klienPerusahaan', function ($kp) use ($search) {
                      $kp->where('nama_cp', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan sektor industri
        if ($request->filled('sektor')) {
            $query->where('sektor_industri', $request->sektor);
        }

        $mitras    = $query->paginate(10)->withQueryString();
        $sektors   = Perusahaan::select('sektor_industri')
                        ->whereNotNull('sektor_industri')
                        ->distinct()
                        ->orderBy('sektor_industri')
                        ->pluck('sektor_industri');

        return view('admin.mitra.index', compact('mitras', 'sektors'));
    }

    /**
     * Tampilkan form tambah mitra baru.
     */
    public function create()
    {
        return view('admin.mitra.create');
    }

    /**
     * Tampilkan form edit mitra.
     */
    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $cp = $perusahaan->klienPerusahaan()->first();
        return view('admin.mitra.edit', compact('perusahaan', 'cp'));
    }

    /**
     * Simpan mitra baru (perusahaan + klien_perusahaan).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'alamat'          => 'nullable|string|max:500',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer|min:0',
            'jabatan'         => 'nullable|string|max:255',
            'nama_cp'         => 'nullable|string|max:255',
            'no_hp_cp'        => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $perusahaan = Perusahaan::create([
                'nama'            => $request->nama,
                'alamat'          => $request->alamat,
                'sektor_industri' => $request->sektor_industri,
                'jumlah_karyawan' => $request->jumlah_karyawan,
            ]);

            // Buat entri CP manual (id_user null = diinput admin)
            KlienPerusahaan::create([
                'id_perusahaan' => $perusahaan->id_perusahaan,
                'id_user'       => null,
                'jabatan'       => $request->jabatan,
                'nama_cp'       => $request->nama_cp,
                'no_hp_cp'      => $request->no_hp_cp,
            ]);
        });

        return redirect()->route('admin.mitra.index')
            ->with('success', "Mitra perusahaan \"{$request->nama}\" berhasil ditambahkan.");
    }

    /**
     * Update data mitra.
     */
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'alamat'          => 'nullable|string|max:500',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer|min:0',
            'jabatan'         => 'nullable|string|max:255',
            'nama_cp'         => 'nullable|string|max:255',
            'no_hp_cp'        => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $perusahaan) {
            $perusahaan->update([
                'nama'            => $request->nama,
                'alamat'          => $request->alamat,
                'sektor_industri' => $request->sektor_industri,
                'jumlah_karyawan' => $request->jumlah_karyawan,
            ]);

            // Ambil CP pertama (bisa dari user terdaftar atau manual)
            $cp = $perusahaan->klienPerusahaan()->first();

            if ($cp) {
                // Preserve id_user yang sudah ada — hanya update jabatan & info manual
                $cp->update([
                    'jabatan'  => $request->jabatan,
                    'nama_cp'  => $request->nama_cp,
                    'no_hp_cp' => $request->no_hp_cp,
                ]);
            } else {
                // Buat CP baru jika belum ada
                KlienPerusahaan::create([
                    'id_perusahaan' => $perusahaan->id_perusahaan,
                    'id_user'       => null,
                    'jabatan'       => $request->jabatan,
                    'nama_cp'       => $request->nama_cp,
                    'no_hp_cp'      => $request->no_hp_cp,
                ]);
            }
        });

        return redirect()->route('admin.mitra.index')
            ->with('success', "Data mitra \"{$perusahaan->nama}\" berhasil diperbarui.");
    }

    /**
     * Hapus mitra (klien_perusahaan dulu, lalu perusahaan).
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        DB::transaction(function () use ($perusahaan) {
            $perusahaan->klienPerusahaan()->delete();
            $perusahaan->delete();
        });

        return redirect()->route('admin.mitra.index')
            ->with('success', "Mitra perusahaan berhasil dihapus.");
    }
}
