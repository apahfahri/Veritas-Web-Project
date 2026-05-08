<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminKlienController extends Controller
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

    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('subadmin.klien.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('subadmin.klien.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('subadmin.klien.index')
            ->with('success', 'Data klien berhasil dihapus.');
    }
}
