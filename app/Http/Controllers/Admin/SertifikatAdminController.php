<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Sertifikat::with(['pendaftaran.user', 'pendaftaran.jadwal.jenis', 'pendaftaran.jadwal.kategori'])->latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_sertifikat', 'like', "%{$search}%")
                  ->orWhereHas('pendaftaran.user', function ($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }
        $sertifikats = $query->paginate(5)->withQueryString();
        
        // Hanya pendaftaran Selesai & Lunas yang belum punya sertifikat
        $pendaftaranTersedia = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])
            ->where('status_progres', 'selesai')
            ->where('status_bayar', 'lunas')
            ->whereDoesntHave('sertifikat')
            ->latest()
            ->get();

        return view('admin.sertifikat.index', compact('sertifikats', 'pendaftaranTersedia'));
    }

    public function create($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])
            ->where('status_progres', 'selesai')
            ->where('status_bayar', 'lunas')
            ->findOrFail($id_pendaftaran);

        if ($pendaftaran->sertifikat) {
            return redirect()->route('admin.sertifikat.index')
                ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
        }
        
        if ($pendaftaran->jumlah_absen > 1) {
            return redirect()->route('admin.sertifikat.index')
                ->with('error', 'Tidak dapat menerbitkan sertifikat: Peserta memiliki jumlah absen lebih dari 1x.');
        }

        return view('admin.sertifikat.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'          => 'required|string|max:255',
            'masa_berlaku'      => 'nullable|date',
            'file_pdf'          => 'required|file|mimes:pdf|max:5120', // 5MB
        ]);
        
        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
        if ($pendaftaran->jumlah_absen > 1) {
            return redirect()->back()->with('error', 'Tidak dapat menerbitkan sertifikat: Peserta memiliki jumlah absen lebih dari 1x.');
        }

        $exists = Sertifikat::where('id_pendaftaran', $request->id_pendaftaran)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Sertifikat untuk pendaftaran ini sudah diterbitkan.');
        }

        // Simpan File
        $file = $request->file('file_pdf');
        $filename = Str::slug($request->no_sertifikat) . '_' . time() . '.pdf';
        $path = $file->storeAs('sertifikat/uploads', $filename, 'public');

        Sertifikat::create([
            'no_sertifikat'  => $request->no_sertifikat,
            'id_pendaftaran' => $request->id_pendaftaran,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'penerbit'          => $request->penerbit,
            'masa_berlaku'      => $request->masa_berlaku,
            'file_pdf'          => $path,
        ]);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Sertifikat {$request->no_sertifikat} berhasil diunggah.");
    }

    public function show($no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        if ($sertifikat->file_pdf && Storage::disk('public')->exists($sertifikat->file_pdf)) {
            return response()->file(storage_path('app/public/' . $sertifikat->file_pdf));
        }

        return redirect()->route('admin.sertifikat.index')->with('error', 'Dokumen fisik tidak ditemukan di server.');
    }

    public function edit($no_sertifikat)
    {
        $sertifikat = Sertifikat::with('pendaftaran.user')->findOrFail($no_sertifikat);
        return view('admin.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        $request->validate([
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat,' . $no_sertifikat . ',no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'          => 'required|string|max:255',
            'masa_berlaku'      => 'nullable|date',
            'file_pdf'          => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $sertifikat, $no_sertifikat) {
            $oldNo = $sertifikat->no_sertifikat;
            $newNo = $request->no_sertifikat;

            $data = [
                'no_sertifikat'  => $newNo,
                'nama_lengkap'   => $request->nama_lengkap,
                'tanggal_terbit' => $request->tanggal_terbit,
                'penerbit'          => $request->penerbit,
                'masa_berlaku'      => $request->masa_berlaku,
            ];

            if ($request->hasFile('file_pdf')) {
                // Hapus file lama
                if ($sertifikat->file_pdf) {
                    Storage::disk('public')->delete($sertifikat->file_pdf);
                }
                
                $file = $request->file('file_pdf');
                $filename = Str::slug($newNo) . '_' . time() . '.pdf';
                $path = $file->storeAs('sertifikat/uploads', $filename, 'public');
                $data['file_pdf'] = $path;
            }

            // Jika nomor berubah, kita perlu update manual karena primary key di Eloquent bisa rese
            if ($oldNo !== $newNo) {
                // Update verifikasi jika ada
                Verifikasi::where('sertifikat_no', $oldNo)->update(['sertifikat_no' => $newNo]);
                
                // Gunakan query builder untuk update PK
                DB::table('sertifikat')->where('no_sertifikat', $oldNo)->update($data);
            } else {
                $sertifikat->update($data);
            }
        });

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Data sertifikat berhasil diperbarui.");
    }

    public function destroy(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);
        $idPendaftaran = $sertifikat->id_pendaftaran;

        $statusBaru = $request->input('kembalikan_ke_proses') ? 'proses' : 'selesai';

        DB::transaction(function () use ($sertifikat, $idPendaftaran, $statusBaru) {
            // Hapus file fisik
            if ($sertifikat->file_pdf) {
                Storage::disk('public')->delete($sertifikat->file_pdf);
            }
            $sertifikat->delete();
            Pendaftaran::where('id_pendaftaran', $idPendaftaran)->update(['status_progres' => $statusBaru]);
        });

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Sertifikat {$no_sertifikat} telah dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
            'zip_file' => 'nullable|file|mimes:zip|max:51200', // max 50MB
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

        // Extract ZIP if uploaded
        $tempDir = null;
        if ($request->hasFile('zip_file')) {
            $zipFile = $request->file('zip_file');
            $tempDir = storage_path('app/temp_sertifikat_import_' . time() . '_' . uniqid());
            
            $zip = new \ZipArchive();
            if ($zip->open($zipFile->getRealPath()) === true) {
                $zip->extractTo($tempDir);
                $zip->close();
            } else {
                $tempDir = null;
            }
        }

        $importedCount = 0;
        $errors = [];

        DB::transaction(function() use ($rows, $tempDir, &$importedCount, &$errors) {
            foreach ($rows as $index => $row) {
                $idOrNomor = trim($row['nomor_pendaftaran'] ?? $row['id_pendaftaran'] ?? $row['email'] ?? '');
                $noSertifikat = trim($row['no_sertifikat'] ?? '');
                $namaLengkap = trim($row['nama_lengkap'] ?? '');
                $tanggalTerbit = trim($row['tanggal_terbit'] ?? '');
                $masaBerlaku = trim($row['masa_berlaku'] ?? '');
                $penerbit = trim($row['penerbit'] ?? 'PT Katiga Veritas Indonesia');
                $fileName = trim($row['file_name'] ?? '');

                if (empty($idOrNomor)) {
                    $errors[] = "Baris " . ($index + 2) . ": nomor_pendaftaran atau email wajib diisi.";
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
                    $errors[] = "Baris " . ($index + 2) . ": Pendaftaran untuk '{$idOrNomor}' tidak ditemukan.";
                    continue;
                }

                // Ensure it doesn't already have a certificate
                if ($pendaftaran->sertifikat) {
                    $errors[] = "Baris " . ($index + 2) . ": Sertifikat untuk '{$idOrNomor}' sudah diterbitkan.";
                    continue;
                }

                // Generate no_sertifikat if empty
                if (empty($noSertifikat)) {
                    $noSertifikat = $this->generateNoSertifikatAuto();
                } else {
                    // Ensure unique
                    $exists = Sertifikat::where('no_sertifikat', $noSertifikat)->exists();
                    if ($exists) {
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

                // Match PDF file if ZIP was uploaded
                $publicPath = null;
                if ($tempDir && !empty($fileName)) {
                    $localPath = $this->findFileRecursive($tempDir, $fileName);
                    if ($localPath) {
                        $storedName = Str::slug($noSertifikat) . '_' . time() . '_' . uniqid() . '.pdf';
                        $publicPath = 'sertifikat/uploads/' . $storedName;
                        Storage::disk('public')->put($publicPath, file_get_contents($localPath));
                    } else {
                        $errors[] = "Baris " . ($index + 2) . ": File PDF '{$fileName}' tidak ditemukan di dalam berkas ZIP.";
                    }
                }

                Sertifikat::create([
                    'no_sertifikat'  => $noSertifikat,
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                    'nama_lengkap'   => $namaLengkap,
                    'tanggal_terbit' => $tglTerbitParsed,
                    'masa_berlaku'   => $masaBerlakuParsed,
                    'penerbit'       => $penerbit,
                    'file_pdf'       => $publicPath,
                ]);

                // Update status_progres to selesai
                $pendaftaran->update(['status_progres' => 'selesai']);

                $importedCount++;
            }
        });

        // Cleanup temp folder
        if ($tempDir) {
            $this->deleteDirRecursive($tempDir);
        }

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} sertifikat. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} sertifikat.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_sertifikat.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'nomor_pendaftaran', 'no_sertifikat', 'nama_lengkap', 'tanggal_terbit',
                'penerbit', 'masa_berlaku', 'file_name'
            ]);
            fputcsv($file, [
                'REG-PLT-AK3U-01', 'KV-ADM-K3-2026-000001', 'Dr. John Doe', '2026-06-01',
                'PT Katiga Veritas Indonesia', '2029-06-01', 'sertifikat_john.pdf'
            ]);
            fputcsv($file, [
                'peserta.jane@example.com', '', 'Jane Smith, M.Si', '2026-06-01',
                'PT Katiga Veritas Indonesia', '', ''
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateNoSertifikatAuto(): string
    {
        $year = date('Y');
        $count = Sertifikat::whereYear('created_at', $year)->count() + 1;
        return sprintf('KV-ADM-K3-%s-%06d', $year, $count);
    }

    private function findFileRecursive($dir, $filename)
    {
        if (!is_dir($dir)) return null;
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        foreach ($it as $file) {
            if ($file->isFile() && strtolower($file->getBasename()) === strtolower($filename)) {
                return $file->getPathname();
            }
        }
        return null;
    }

    private function deleteDirRecursive($dir)
    {
        if (!is_dir($dir)) return;
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirRecursive("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
