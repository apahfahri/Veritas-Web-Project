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
use Illuminate\Support\Facades\DB;

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

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        // Auto-detect delimiter
        $delimiter = ',';
        if (($handle = fopen($filePath, 'r')) !== false) {
            $firstLine = fgets($handle);
            if ($firstLine !== false) {
                if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                    $delimiter = ';';
                }
            }
            fclose($handle);
        }

        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, $delimiter);
            if ($header) {
                $header = array_map(function($h) {
                    return strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)));
                }, $header);
            }

            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (count($data) >= count($header)) {
                    $rows[] = array_combine(array_slice($header, 0, count($data)), $data);
                } else {
                    $row = [];
                    foreach ($header as $index => $colName) {
                        $row[$colName] = $data[$index] ?? null;
                    }
                    $rows[] = $row;
                }
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return back()->with('error', 'Berkas CSV kosong atau format tidak sesuai.');
        }

        $importedCount = 0;
        $errors = [];
        DB::transaction(function() use ($rows, &$importedCount, &$errors) {
            foreach ($rows as $index => $row) {
                $kode_kategori = strtoupper(trim($row['kode_kategori'] ?? ''));
                $kode_jenis = strtoupper(trim($row['kode_jenis'] ?? ''));
                $jenis_pertemuan = strtolower(trim($row['jenis_pertemuan'] ?? ''));
                $tgl_mulai = trim($row['tgl_mulai'] ?? '');
                $tgl_selesai = trim($row['tgl_selesai'] ?? '');
                $jam_pertemuan = trim($row['jam_pertemuan'] ?? '');
                $lokasi = trim($row['lokasi'] ?? '');
                $kapasitas = trim($row['kapasitas'] ?? '');
                $harga = trim($row['harga'] ?? '0');
                $deskripsi = trim($row['deskripsi'] ?? '');
                $link_meet = trim($row['link_meet'] ?? '');

                if (empty($kode_kategori) || empty($kode_jenis)) {
                    $errors[] = "Baris " . ($index + 2) . ": Kode Kategori dan Kode Jenis Program wajib diisi.";
                    continue;
                }

                $kategori = KategoriLayanan::where('kode_kategori', $kode_kategori)->first();
                if (!$kategori) {
                    $kategori = KategoriLayanan::where('nama', $row['kode_kategori'] ?? '')->first();
                }

                if (!$kategori) {
                    $errors[] = "Baris " . ($index + 2) . ": Kategori dengan kode/nama '{$kode_kategori}' tidak ditemukan.";
                    continue;
                }

                $jenis = JenisLayanan::where('id_kategori', $kategori->id_kategori)
                    ->where('kode_jenis', $kode_jenis)
                    ->first();
                if (!$jenis) {
                    $jenis = JenisLayanan::where('id_kategori', $kategori->id_kategori)
                        ->where('nama', $row['kode_jenis'] ?? '')
                        ->first();
                }

                if (!$jenis) {
                    $errors[] = "Baris " . ($index + 2) . ": Jenis program dengan kode/nama '{$kode_jenis}' tidak ditemukan di kategori ini.";
                    continue;
                }

                if (!in_array($jenis_pertemuan, ['online', 'offline', 'hybrid'])) {
                    $jenis_pertemuan = 'offline';
                }

                // Generate kode_jadwal
                $urutan = Jadwal::where('id_jenis', $jenis->id_jenis)->count() + 1;
                $urutanFormat = str_pad($urutan, 2, '0', STR_PAD_LEFT);
                $kode_jadwal = "{$kategori->kode_kategori}-{$jenis->kode_jenis}-{$urutanFormat}";

                Jadwal::create([
                    'id_kategori'     => $kategori->id_kategori,
                    'id_jenis'        => $jenis->id_jenis,
                    'kode_jadwal'     => $kode_jadwal,
                    'jenis_pertemuan' => $jenis_pertemuan,
                    'tgl_mulai'       => empty($tgl_mulai) ? null : $tgl_mulai,
                    'tgl_selesai'     => empty($tgl_selesai) ? null : $tgl_selesai,
                    'jam_pertemuan'   => empty($jam_pertemuan) ? null : $jam_pertemuan,
                    'lokasi'          => empty($lokasi) ? null : $lokasi,
                    'kapasitas'       => is_numeric($kapasitas) ? intval($kapasitas) : null,
                    'harga'           => is_numeric($harga) ? floatval($harga) : 0,
                    'deskripsi'       => empty($deskripsi) ? null : $deskripsi,
                    'link_meet'       => empty($link_meet) ? null : $link_meet,
                ]);
                $importedCount++;
            }
        });

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} jadwal. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} jadwal pelatihan.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_jadwal.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'kode_kategori', 'kode_jenis', 'jenis_pertemuan', 'tgl_mulai', 'tgl_selesai',
                'jam_pertemuan', 'lokasi', 'kapasitas', 'harga', 'deskripsi', 'link_meet'
            ]);
            fputcsv($file, [
                'PLT', 'AK3U', 'online', '2026-07-01', '2026-07-05',
                '08:00 - 16:00', 'Online Zoom', '30', '2500000', 'Pelatihan Ahli K3 Umum Sertifikasi Kemnaker RI', 'https://zoom.us/j/123456789'
            ]);
            fputcsv($file, [
                'PLT', 'K3L', 'offline', '2026-08-10', '2026-08-12',
                '09:00 - 17:00', 'Hotel Veritas Jakarta', '15', '3500000', 'Pelatihan K3 Lingkungan Kerja', ''
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
