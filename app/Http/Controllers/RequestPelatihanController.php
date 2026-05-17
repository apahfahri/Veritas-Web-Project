<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\KlienPerusahaan;
use App\Models\RequestPelatihan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestPelatihanController extends Controller
{
    public function create()
    {
        $jenisLayanan = JenisLayanan::where('id_kategori', 1)->orderBy('nama', 'asc')->get();
        return view('pages.request-training', compact('jenisLayanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'no_telp'           => 'required|string|max:20',
            'nama_perusahaan'   => 'required|string|max:255',
            'jabatan'           => 'nullable|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'sektor_industri'   => 'nullable|string|max:255',
            'jumlah_peserta'    => 'nullable|integer|min:1',
            'topik_pelatihan'   => 'required|string|max:255',
            'tanggal_harapan'   => 'nullable|date',
            'pesan_tambahan'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Upsert data Perusahaan (insert or update by nama)
            $perusahaan = Perusahaan::firstOrCreate(
                ['nama' => $validated['nama_perusahaan']],
                [
                    'alamat'          => $validated['alamat_perusahaan'],
                    'sektor_industri' => $validated['sektor_industri'] ?? null,
                ]
            );

            // 2. Upsert data KlienPerusahaan (PIC) — match by email + perusahaan
            KlienPerusahaan::updateOrCreate(
                [
                    'id_perusahaan' => $perusahaan->id_perusahaan,
                    'nama_cp'       => $validated['nama_lengkap'],
                ],
                [
                    'id_user'   => null,
                    'jabatan'   => $validated['jabatan'] ?? null,
                    'no_hp_cp'  => $validated['no_telp'],
                ]
            );

            // 3. Simpan data RequestPelatihan
            RequestPelatihan::create([
                'id_perusahaan'     => $perusahaan->id_perusahaan,
                'nama_lengkap'      => $validated['nama_lengkap'],
                'email'             => $validated['email'],
                'no_telp'           => $validated['no_telp'],
                'nama_perusahaan'   => $validated['nama_perusahaan'],
                'jabatan'           => $validated['jabatan'] ?? null,
                'alamat_perusahaan' => $validated['alamat_perusahaan'],
                'sektor_industri'   => $validated['sektor_industri'] ?? null,
                'jumlah_karyawan'   => $validated['jumlah_peserta'] ?? null,
                'topik_pelatihan'   => $validated['topik_pelatihan'],
                'tanggal_harapan'   => $validated['tanggal_harapan'] ?? null,
                'pesan_tambahan'    => $validated['pesan_tambahan'] ?? null,
                'status'            => 'pending',
            ]);
        });

        return redirect()
            ->route('training.list')
            ->with('success', 'Request pelatihan berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    /**
     * Admin: daftar semua request pelatihan
     */
    public function index(Request $request)
    {
        $query = RequestPelatihan::with('perusahaan')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->search . '%')
                  ->orWhere('topik_pelatihan', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->paginate(15)->withQueryString();
        return view('admin.request-pelatihan.index', compact('requests'));
    }

    /**
     * Admin: detail request pelatihan
     */
    public function show($id)
    {
        $item = RequestPelatihan::with('perusahaan')->findOrFail($id);
        return view('admin.request-pelatihan.show', compact('item'));
    }

    /**
     * Admin: update status request
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,dihubungi,selesai,ditolak']);
        $item = RequestPelatihan::findOrFail($id);
        $item->update(['status' => $request->status]);

        return back()->with('success', 'Status request berhasil diperbarui.');
    }
}
