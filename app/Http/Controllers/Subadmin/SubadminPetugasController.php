<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pemateri;
use Illuminate\Support\Facades\Auth;

class SubadminPetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak. Halaman khusus Subadmin.');
            }
            return $next($request);
        });
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $query = Pemateri::query();
        
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $pemateris = $query->latest()->paginate(15)->withQueryString();
        return view('subadmin.petugas.index', compact('pemateris'));
    }
}
