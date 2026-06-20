<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekeningController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isSuperAdmin()) {
                abort(403, 'Akses ditolak. Halaman ini khusus untuk Superadmin.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Rekening::latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('bank', 'like', "%{$search}%")
                  ->orWhere('atas_nama', 'like', "%{$search}%")
                  ->orWhere('nomor_rekening', 'like', "%{$search}%");
            });
        }
        $rekenings = $query->paginate(10)->withQueryString();
        return view('admin.rekening.index', compact('rekenings'));
    }

    public function create()
    {
        return view('admin.rekening.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank'      => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama'      => 'required|string|max:255',
        ]);

        Rekening::create([
            'nama_bank'      => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama'      => $request->atas_nama,
            'status_aktif'   => false, // Default false, must be activated via toggle
        ]);

        return redirect()->route('admin.rekening.index')
            ->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('admin.rekening.edit', compact('rekening'));
    }

    public function update(Request $request, $id)
    {
        $rekening = Rekening::findOrFail($id);

        $request->validate([
            'nama_bank'      => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama'      => 'required|string|max:255',
        ]);

        $rekening->update([
            'nama_bank'      => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama'      => $request->atas_nama,
        ]);

        return redirect()->route('admin.rekening.index')
            ->with('success', 'Rekening berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();

        return redirect()->route('admin.rekening.index')
            ->with('success', 'Rekening berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $rekening = Rekening::findOrFail($id);
        $newStatus = !$rekening->status_aktif;

        DB::transaction(function () use ($rekening, $newStatus) {
            if ($newStatus) {
                // Deactivate all other accounts
                Rekening::query()->update(['status_aktif' => false]);
            }
            $rekening->update(['status_aktif' => $newStatus]);
        });

        return redirect()->route('admin.rekening.index')
            ->with('success', 'Status aktif rekening berhasil diperbarui.');
    }
}
