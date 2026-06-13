<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubadminSertifikatController extends Controller
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

    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'terbit');
        $search = $request->query('search');
        $cabang = Auth::user()->cabang;

        if ($activeTab === 'belum') {
            // Pendaftaran Selesai & Lunas yang belum punya sertifikat
            $query = Pendaftaran::where('status_progres', 'selesai')
                ->where('status_bayar', 'lunas')
                ->whereDoesntHave('sertifikat')
                ->with(['user', 'jadwal.jenis', 'jadwal.kategori']);

            // Branch filtering for individuals is deprecated since klien_individu was removed.

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nomor_pendaftaran', 'LIKE', "%{$search}%")
                      ->orWhereHas('user', function($qu) use ($search) {
                          $qu->where('nama', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('jadwal.jenis', function($qj) use ($search) {
                          $qj->where('nama', 'LIKE', "%{$search}%");
                      });
                });
            }

            $pendaftaranBelum = $query->latest()->paginate(15, ['*'], 'page_belum')->withQueryString();
            $sertifikats = null;
        } else {
            // Tab: terbit
            $query = Sertifikat::whereHas('pendaftaran', function($q) use ($cabang) {
                // Branch filtering for individuals is deprecated since klien_individu was removed.
            })->with(['pendaftaran.user', 'pendaftaran.jadwal.jenis']);

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('no_sertifikat', 'LIKE', "%{$search}%")
                      ->orWhere('nama_lengkap', 'LIKE', "%{$search}%")
                      ->orWhereHas('pendaftaran.user', function($qu) use ($search) {
                          $qu->where('email', 'LIKE', "%{$search}%");
                      });
                });
            }

            $sertifikats = $query->latest()->paginate(15, ['*'], 'page_terbit')->withQueryString();
            $pendaftaranBelum = null;
        }

        return view('subadmin.sertifikat.index', compact('sertifikats', 'pendaftaranBelum', 'activeTab'));
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

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        DB::transaction(function() use ($rows, &$successCount, &$errorCount, &$errors) {
            foreach ($rows as $index => $row) {
                $idOrNomor = trim($row['nomor_pendaftaran'] ?? $row['id_pendaftaran'] ?? $row['email'] ?? '');
                $noSertifikat = trim($row['no_sertifikat'] ?? '');
                $namaLengkap = trim($row['nama_lengkap'] ?? '');
                $tanggalTerbit = trim($row['tanggal_terbit'] ?? '');
                $masaBerlaku = trim($row['masa_berlaku'] ?? '');
                $penerbit = trim($row['penerbit'] ?? 'PT Katiga Veritas Indonesia');

                if (empty($idOrNomor)) {
                    $errorCount++;
                    $errors[] = "Baris " . ($index + 2) . ": nomor_pendaftaran atau email kosong.";
                    continue;
                }

                // Find Pendaftaran
                $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $idOrNomor)
                    ->orWhere('id_pendaftaran', $idOrNomor)
                    ->orWhereHas('user', function($q) use ($idOrNomor) {
                        $q->where('email', $idOrNomor);
                    })
                    ->first();

                if (!$pendaftaran) {
                    $errorCount++;
                    $errors[] = "Baris " . ($index + 2) . ": Pendaftaran untuk '{$idOrNomor}' tidak ditemukan.";
                    continue;
                }

                // Check branch authorization
                $cabang = Auth::user()->cabang;
                // Branch filtering for individuals is deprecated

                // Ensure it doesn't already have a certificate
                if ($pendaftaran->sertifikat) {
                    $errorCount++;
                    $errors[] = "Baris " . ($index + 2) . ": Sertifikat untuk '{$idOrNomor}' sudah ada.";
                    continue;
                }

                // Generate no_sertifikat if empty
                if (empty($noSertifikat)) {
                    $noSertifikat = $this->generateNoSertifikat();
                } else {
                    // Ensure unique
                    $exists = Sertifikat::where('no_sertifikat', $noSertifikat)->exists();
                    if ($exists) {
                        $errorCount++;
                        $errors[] = "Baris " . ($index + 2) . ": Nomor sertifikat '{$noSertifikat}' sudah digunakan.";
                        continue;
                    }
                }

                // Validate and format dates
                $tglTerbitParsed = null;
                if (!empty($tanggalTerbit)) {
                    try {
                        $tglTerbitParsed = \Carbon\Carbon::parse($tanggalTerbit)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $tglTerbitParsed = date('Y-m-d');
                    }
                } else {
                    $tglTerbitParsed = date('Y-m-d');
                }

                $masaBerlakuParsed = null;
                if (!empty($masaBerlaku)) {
                    try {
                        $masaBerlakuParsed = \Carbon\Carbon::parse($masaBerlaku)->format('Y-m-d');
                    } catch (\Exception $e) {}
                }

                // If nama_lengkap is empty, use user name
                if (empty($namaLengkap)) {
                    $namaLengkap = $pendaftaran->user?->nama ?? 'Peserta';
                }

                Sertifikat::create([
                    'no_sertifikat'  => $noSertifikat,
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                    'nama_lengkap'   => $namaLengkap,
                    'tanggal_terbit' => $tglTerbitParsed,
                    'masa_berlaku'   => $masaBerlakuParsed,
                    'penerbit'       => $penerbit,
                ]);

                // Update status_progres to selesai
                $pendaftaran->update(['status_progres' => 'selesai']);

                $successCount++;
            }
        });

        if ($errorCount > 0) {
            $msg = "Impor selesai dengan beberapa catatan: {$successCount} sertifikat berhasil diimpor, {$errorCount} baris gagal. Detail: " . implode(" | ", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$successCount} sertifikat.");
    }

    public function create($pendaftaran_id = null)
    {
        $cabang = Auth::user()->cabang;

        if ($pendaftaran_id) {
            $pendaftaran = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])->findOrFail($pendaftaran_id);

            // Alur Sertifikat: "Sertifikat hanya boleh diterbitkan jika status pendaftaran sudah 'Completed' atau 'Lulus'."
            $allowedStatuses = ['selesai', 'lulus', 'completed'];
            if (!in_array(strtolower($pendaftaran->status_progres), $allowedStatuses)) {
                return redirect()->route('subadmin.pendaftaran.show', $pendaftaran_id)
                    ->with('error', 'Sertifikat hanya dapat diterbitkan untuk pendaftaran dengan status Selesai atau Lulus.');
            }

            if ($pendaftaran->sertifikat) {
                return redirect()->route('subadmin.sertifikat.index')
                    ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
            }

            $pendaftaranTersedia = collect([$pendaftaran]);
        } else {
            // Fetch all eligible registrations
            $query = Pendaftaran::where('status_progres', 'selesai')
                ->where('status_bayar', 'lunas')
                ->whereDoesntHave('sertifikat')
                ->with(['user', 'jadwal.jenis']);

            // Branch filtering for individuals is deprecated since klien_individu was removed.

            $pendaftaranTersedia = $query->latest()->get();
            $pendaftaran = null;
        }

        return view('subadmin.sertifikat.create', compact('pendaftaran', 'pendaftaranTersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'       => 'required|string|max:255',
            'masa_berlaku'   => 'nullable|date',
            'file_pdf'       => 'required|file|mimes:pdf|max:5120',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Security check for branch is deprecated

        // Save file
        $file = $request->file('file_pdf');
        $filename = Str::slug($request->no_sertifikat) . '_' . time() . '.pdf';
        $path = $file->storeAs('sertifikat/uploads', $filename, 'public');

        Sertifikat::create([
            'no_sertifikat'  => $request->no_sertifikat,
            'id_pendaftaran' => $request->id_pendaftaran,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'penerbit'       => $request->penerbit,
            'masa_berlaku'   => $request->masa_berlaku,
            'file_pdf'       => $path,
        ]);

        $pendaftaran->update(['status_progres' => 'selesai']);

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', "Sertifikat {$request->no_sertifikat} berhasil diunggah.");
    }

    public function show($no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        if ($sertifikat->file_pdf && Storage::disk('public')->exists($sertifikat->file_pdf)) {
            return response()->file(storage_path('app/public/' . $sertifikat->file_pdf));
        }

        return redirect()->route('subadmin.sertifikat.index')->with('error', 'Dokumen fisik tidak ditemukan di server.');
    }

    public function edit($no_sertifikat)
    {
        $sertifikat = Sertifikat::with('pendaftaran.user')->findOrFail($no_sertifikat);
        return view('subadmin.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        $request->validate([
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat,' . $no_sertifikat . ',no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'       => 'required|string|max:255',
            'masa_berlaku'   => 'nullable|date',
            'file_pdf'       => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $sertifikat, $no_sertifikat) {
            $oldNo = $sertifikat->no_sertifikat;
            $newNo = $request->no_sertifikat;

            $data = [
                'no_sertifikat'  => $newNo,
                'nama_lengkap'   => $request->nama_lengkap,
                'tanggal_terbit' => $request->tanggal_terbit,
                'penerbit'       => $request->penerbit,
                'masa_berlaku'   => $request->masa_berlaku,
            ];

            if ($request->hasFile('file_pdf')) {
                if ($sertifikat->file_pdf) {
                    Storage::disk('public')->delete($sertifikat->file_pdf);
                }
                $file = $request->file('file_pdf');
                $filename = Str::slug($newNo) . '_' . time() . '.pdf';
                $path = $file->storeAs('sertifikat/uploads', $filename, 'public');
                $data['file_pdf'] = $path;
            }

            if ($oldNo !== $newNo) {
                Verifikasi::where('sertifikat_no', $oldNo)->update(['sertifikat_no' => $newNo]);
                DB::table('sertifikat')->where('no_sertifikat', $oldNo)->update($data);
            } else {
                $sertifikat->update($data);
            }
        });

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', "Data sertifikat berhasil diperbarui.");
    }

    public function destroy(Request $request, $no_sertifikat)
    {
        try {
            $sertifikat = Sertifikat::findOrFail($no_sertifikat);
            $idPendaftaran = $sertifikat->id_pendaftaran;
            $statusBaru = $request->input('kembalikan_ke_proses') ? 'proses' : 'selesai';

            DB::transaction(function () use ($sertifikat, $idPendaftaran, $statusBaru) {
                if ($sertifikat->file_pdf) {
                    Storage::disk('public')->delete($sertifikat->file_pdf);
                }
                $sertifikat->delete();
                Pendaftaran::where('id_pendaftaran', $idPendaftaran)->update(['status_progres' => $statusBaru]);
            });

            return redirect()->route('subadmin.sertifikat.index')
                ->with('success', "Sertifikat {$no_sertifikat} telah dihapus.");
        } catch (\Exception $e) {
            return redirect()->route('subadmin.sertifikat.index')
                ->with('error', 'Gagal menghapus sertifikat: ' . $e->getMessage());
        }
    }
}
