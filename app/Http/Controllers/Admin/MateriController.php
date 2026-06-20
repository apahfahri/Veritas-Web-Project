<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $query = Materi::latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%");
            });
        }
        $materis = $query->paginate(5)->withQueryString();
        return view('admin.materi.index', compact('materis'));
    }

    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_materi' => 'required|file|mimes:pdf|max:10240', // max 10MB
            'deskripsi' => 'nullable|string'
        ]);

        $path = $request->file('file_materi')->store('materi', 'public');

        Materi::create([
            'judul' => $request->judul,
            'file_path' => $path,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_materi' => 'nullable|file|mimes:pdf|max:10240',
            'deskripsi' => 'nullable|string'
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if ($request->hasFile('file_materi')) {
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $data['file_path'] = $request->file('file_materi')->store('materi', 'public');
        }

        $materi->update($data);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }
        $materi->delete();

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
            'zip_file' => 'required|file|mimes:zip|max:51200', // max 50MB
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

        // Extract ZIP
        $zipFile = $request->file('zip_file');
        $tempDir = storage_path('app/temp_materi_import_' . time() . '_' . uniqid());
        
        $zip = new \ZipArchive();
        if ($zip->open($zipFile->getRealPath()) !== true) {
            return back()->with('error', 'Gagal membuka berkas ZIP.');
        }
        $zip->extractTo($tempDir);
        $zip->close();

        $importedCount = 0;
        $errors = [];

        DB::transaction(function() use ($rows, $tempDir, &$importedCount, &$errors) {
            foreach ($rows as $index => $row) {
                $judul = trim($row['judul'] ?? '');
                $deskripsi = trim($row['deskripsi'] ?? '');
                $fileName = trim($row['file_name'] ?? '');

                if (empty($judul)) {
                    $errors[] = "Baris " . ($index + 2) . ": Judul materi wajib diisi.";
                    continue;
                }

                if (empty($fileName)) {
                    $errors[] = "Baris " . ($index + 2) . ": Nama file PDF wajib diisi.";
                    continue;
                }

                // Search file in extracted ZIP
                $localPath = $this->findFileRecursive($tempDir, $fileName);
                if (!$localPath) {
                    $errors[] = "Baris " . ($index + 2) . ": File '{$fileName}' tidak ditemukan di dalam berkas ZIP.";
                    continue;
                }

                // Store file
                $storedName = Str::slug($judul) . '_' . time() . '_' . uniqid() . '.pdf';
                $publicPath = 'materi/' . $storedName;
                Storage::disk('public')->put($publicPath, file_get_contents($localPath));

                Materi::create([
                    'judul'     => $judul,
                    'file_path' => $publicPath,
                    'deskripsi' => empty($deskripsi) ? null : $deskripsi,
                ]);

                $importedCount++;
            }
        });

        // Cleanup temp folder
        $this->deleteDirRecursive($tempDir);

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} materi. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} materi.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_materi.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['judul', 'deskripsi', 'file_name']);
            fputcsv($file, ['Materi Dasar K3', 'Pengenalan prinsip dasar K3 untuk pemula', 'dasar_k3.pdf']);
            fputcsv($file, ['Materi K3 Konstruksi', 'Pedoman keselamatan kerja di area konstruksi bangunan', 'k3_konstruksi.pdf']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
