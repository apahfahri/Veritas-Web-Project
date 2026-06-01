<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use App\Models\Pemateri;
use App\Models\Materi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainingReminderMail;

class LayananAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kategori', 'jenis', 'pemateri']);
        
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

        $jadwals = $query->latest()->paginate(5)->appends(['filter' => $filter]);
        return view('admin.jadwal.index', compact('jadwals', 'filter'));
    }

    public function show($id)
    {
        $jadwal   = Jadwal::with(['kategori', 'jenis', 'pemateri'])->findOrFail($id);
        $pesertas = Pendaftaran::where('id_jadwal', $id)
            ->where('status_progres', '!=', 'dibatalkan')
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('admin.jadwal.show', compact('jadwal', 'pesertas'));
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

        return redirect()->route('admin.jadwal.show', $id)
            ->with('success', "Berhasil mengirim $count email reminder.");
    }

    public function create()
    {
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        $materis = Materi::latest()->get();
        return view('admin.jadwal.create', compact('kategoris', 'pemateris', 'materis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'jam_pertemuan'  => 'nullable',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
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
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kategori = KategoriLayanan::findOrFail($request->id_kategori);
        $jenis = JenisLayanan::findOrFail($request->id_jenis);
        $urutan = Jadwal::where('id_jenis', $request->id_jenis)->count() + 1;
        $urutanFormat = str_pad($urutan, 2, '0', STR_PAD_LEFT);
        $kode_jadwal = "{$kategori->kode_kategori}-{$jenis->kode_jenis}-{$urutanFormat}";

        $data = array_merge($request->only([
            'id_kategori', 'id_jenis', 'jenis_pertemuan',
            'jam_pertemuan', 'tgl_mulai', 'tgl_selesai',
            'lokasi', 'kapasitas', 'harga', 'deskripsi', 'link_meet',
        ]), ['kode_jadwal' => $kode_jadwal]);

        if ($request->hasFile('file_rundown')) {
            $data['file_rundown'] = $request->file('file_rundown')->store('rundown', 'public');
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('jadwal', 'public');
        }

        $jadwal = Jadwal::create($data);

        if ($request->filled('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        }
        
        if ($request->filled('materi_ids')) {
            $jadwal->materi()->sync($request->materi_ids);
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal    = Jadwal::with(['pemateri', 'materi'])->findOrFail($id);
        $kategoris = KategoriLayanan::with('jenis')->get();
        $pemateris = Pemateri::orderBy('nama_lengkap')->get();
        $materis = Materi::latest()->get();
        return view('admin.jadwal.edit', compact('jadwal', 'kategoris', 'pemateris', 'materis'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'id_kategori'    => 'required|exists:kategori_layanan,id_kategori',
            'id_jenis'       => 'required|exists:jenis_layanan,id_jenis',
            'kode_jadwal'    => 'nullable|string|max:20',
            'jenis_pertemuan'=> 'required|in:online,offline,hybrid',
            'jam_pertemuan'  => 'nullable',
            'tgl_mulai'      => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
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
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'id_kategori', 'id_jenis', 'jenis_pertemuan',
            'jam_pertemuan', 'tgl_mulai', 'tgl_selesai',
            'lokasi', 'kapasitas', 'harga', 'deskripsi', 'link_meet',
        ]);

        if ($request->hasFile('file_rundown')) {
            if ($jadwal->file_rundown) {
                Storage::disk('public')->delete($jadwal->file_rundown);
            }
            $data['file_rundown'] = $request->file('file_rundown')->store('rundown', 'public');
        }

        if ($request->hasFile('foto')) {
            if ($jadwal->foto) {
                Storage::disk('public')->delete($jadwal->foto);
            }
            $data['foto'] = $request->file('foto')->store('jadwal', 'public');
        }

        $jadwal->update($data);

        if ($request->has('pemateri_ids')) {
            $jadwal->pemateri()->sync($request->pemateri_ids);
        } else {
            $jadwal->pemateri()->detach();
        }

        if ($request->has('materi_ids')) {
            $jadwal->materi()->sync($request->materi_ids);
        } else {
            $jadwal->materi()->detach();
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        if ($jadwal->file_rundown) {
            Storage::disk('public')->delete($jadwal->file_rundown);
        }
        if ($jadwal->foto) {
            Storage::disk('public')->delete($jadwal->foto);
        }
        $jadwal->pemateri()->detach();
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal layanan berhasil dihapus.');
    }
}
