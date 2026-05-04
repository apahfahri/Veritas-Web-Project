<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $pendaftarans = Pendaftaran::with(['layanan', 'sertifikat'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total'      => $pendaftarans->count(),
            'selesai'    => $pendaftarans->where('status_progres', 'selesai')->count(),
            'sertifikat' => $pendaftarans->filter(fn($p) => $p->sertifikat)->count(),
            'menunggu'   => $pendaftarans->where('status_progres', 'menunggu')->count(),
        ];

        return view('pages.dashboard', compact('pendaftarans', 'stats', 'user'));
    }
}
