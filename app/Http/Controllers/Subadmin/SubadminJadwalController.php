<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use App\Models\Pemateri;
use App\Models\Pendaftaran;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainingReminderMail;

class SubadminJadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Jadwal::with(['kategori', 'jenis', 'pemateri'])
            ->whereHas('kategori', function($q) {
                $q->where('nama', 'like', '%Pelatihan%');
            })
            ->whereDoesntHave('pendaftarans', function ($q) {
                $q->where('is_kustom', true);
            })
            ->withCount(['pendaftarans as pending_count' => function ($q) {
                $q->where('status_progres', 'menunggu');
            }]);

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        if ($request->filled('jenis_pertemuan')) {
            $query->where('jenis_pertemuan', $request->jenis_pertemuan);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jenis', fn($q) => $q->where('nama', 'like', "%{$search}%"));
        }

        $filter = $request->input('filter', 'akan_datang');

        if ($filter === 'akan_datang') {
            $query->where(function ($q) {
                $q->whereDate('tgl_mulai', '>=', now())
                  ->orWhereDate('tgl_selesai', '>=', now())
                  ->orWhereNull('tgl_mulai');
            });
        } elseif ($filter === 'riwayat') {
            $query->where(function ($q) {
                $q->whereDate('tgl_mulai', '<', now())
                  ->where(function ($sub) {
                      $sub->whereDate('tgl_selesai', '<', now())
                          ->orWhereNull('tgl_selesai');
                  });
            });
        }

        $jadwals   = $query->latest()->paginate(15)->appends($request->all());
        $kategoris = KategoriLayanan::where('nama', 'like', '%Pelatihan%')->get();

        return view('subadmin.jadwal.index', compact('jadwals', 'kategoris', 'filter'));
    }

    public function show($id)
    {
        $jadwal   = Jadwal::with(['pemateri', 'materi'])->findOrFail($id);
        $pesertas = Pendaftaran::where('id_jadwal', $id)
            ->where('status_progres', '!=', 'dibatalkan')
            ->with('user')
            ->latest()
            ->get();
        return view('subadmin.jadwal.show', compact('jadwal', 'pesertas'));
    }

    public function resendReminder($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        if (in_array($jadwal->jenis_pertemuan, ['online', 'hybrid']) && empty($jadwal->link_meet)) {
            return redirect()->back()->with('error', 'Gagal mengirim email konfirmasi. Link Meet belum diisi untuk jadwal online/hybrid.');
        }

        $pendaftarans = Pendaftaran::where('id_jadwal', $jadwal->id_jadwal)
            ->where('status_progres', 'diproses')
            ->get();

        $count = 0;
        foreach ($pendaftarans as $pendaftaran) {
            $email = $pendaftaran->user->email ?? null;
            if ($email) {
                Mail::to($email)->send(new TrainingReminderMail($pendaftaran));
                $count++;
            }
        }

        $jadwal->update(['reminder_h3_sent_at' => now()]);

        return redirect()->route('subadmin.jadwal.show', $id)
            ->with('success', "Berhasil mengirim $count email reminder.");
    }

    public function create()
    {
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        $materis = Materi::latest()->get();
        return view('subadmin.jadwal.create', compact('kategoris', 'pemateris', 'materis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'kode_jadwal'    => 'nullable|string|max:20',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
            'jam_pertemuan'  => 'nullable',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'harga'          => 'required|numeric|min:0',
            'deskripsi'      => 'nullable|string',
            'pemateri_ids'   => 'nullable|array',
            'pemateri_ids.*' => 'exists:pemateri,id_pemateri',
            'materi_ids'     => 'nullable|array',
            'materi_ids.*'   => 'exists:materi,id_materi',
            'link_meet'      => 'nullable|url|max:255',
            'file_rundown'   => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->only([
            'id_kategori', 'id_jenis', 'kode_jadwal', 'jenis_pertemuan',
            'tgl_mulai', 'tgl_selesai', 'jam_pertemuan', 'lokasi',
            'kapasitas', 'harga', 'deskripsi', 'link_meet',
        ]);

        if ($request->hasFile('file_rundown')) {
            $data['file_rundown'] = $request->file('file_rundown')->store('rundown', 'public');
        }

        $jadwal = Jadwal::create($data);

        if ($request->filled('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        }
        
        if ($request->filled('materi_ids')) {
            $jadwal->materi()->sync($request->materi_ids);
        }

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal    = Jadwal::with(['pemateri', 'materi'])->findOrFail($id);
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        $materis = Materi::latest()->get();
        return view('subadmin.jadwal.edit', compact('jadwal', 'kategoris', 'pemateris', 'materis'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'materi_ids'     => 'nullable|array',
            'materi_ids.*'   => 'exists:materi,id_materi',
            'file_rundown'   => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = [];

        if ($request->hasFile('file_rundown')) {
            if ($jadwal->file_rundown) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($jadwal->file_rundown);
            }
            $data['file_rundown'] = $request->file('file_rundown')->store('rundown', 'public');
        }

        if (!empty($data)) {
            $jadwal->update($data);
        }

        if ($request->has('materi_ids')) {
            $jadwal->materi()->sync($request->materi_ids);
        } else {
            $jadwal->materi()->detach();
        }

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        if ($jadwal->file_rundown) {
            Storage::disk('public')->delete($jadwal->file_rundown);
        }
        $jadwal->pemateri()->detach();
        $jadwal->delete();

        return redirect()->route('subadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
