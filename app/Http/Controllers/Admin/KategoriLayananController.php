<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriLayananController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriLayanan::with('jenis');
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        $kategoris = $query->paginate(10)->withQueryString();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // ─── Kategori CRUD ───────────────────────────────────────

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'kode_kategori'  => 'required|string|max:10|unique:kategori_layanan,kode_kategori',
            'deskripsi'      => 'nullable|string',
        ]);

        KategoriLayanan::create($request->only(['nama', 'kode_kategori', 'deskripsi']));

        return back()->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = KategoriLayanan::findOrFail($id);

        $request->validate([
            'nama'           => 'required|string|max:100',
            'kode_kategori'  => 'required|string|max:10|unique:kategori_layanan,kode_kategori,' . $id . ',id_kategori',
            'deskripsi'      => 'nullable|string',
        ]);

        $kategori->update($request->only(['nama', 'kode_kategori', 'deskripsi']));

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori($id)
    {
        $kategori = KategoriLayanan::findOrFail($id);
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // ─── Jenis Layanan CRUD ──────────────────────────────────

    public function storeJenis(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_layanan,id_kategori',
            'nama'        => 'required|string|max:255',
            'kode_jenis'  => 'nullable|string|max:15',
        ]);

        JenisLayanan::create($request->only(['id_kategori', 'nama', 'kode_jenis']));

        return back()->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function updateJenis(Request $request, $id)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'kode_jenis' => 'nullable|string|max:15',
        ]);

        $jenis = JenisLayanan::findOrFail($id);
        $jenis->update($request->only(['nama', 'kode_jenis']));

        return back()->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroyJenis($id)
    {
        $jenis = JenisLayanan::findOrFail($id);
        $jenis->delete();

        return back()->with('success', 'Jenis layanan berhasil dihapus.');
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
                $nama_kategori = trim($row['nama_kategori'] ?? '');
                $deskripsi_kategori = trim($row['deskripsi_kategori'] ?? '');
                $kode_jenis = strtoupper(trim($row['kode_jenis'] ?? ''));
                $nama_jenis = trim($row['nama_jenis'] ?? '');

                if (empty($kode_kategori) || empty($nama_kategori)) {
                    $errors[] = "Baris " . ($index + 2) . ": Kode dan Nama Kategori wajib diisi.";
                    continue;
                }

                $kategori = KategoriLayanan::where('kode_kategori', $kode_kategori)->first();
                if (!$kategori) {
                    $kategori = KategoriLayanan::create([
                        'kode_kategori' => $kode_kategori,
                        'nama'          => $nama_kategori,
                        'deskripsi'     => empty($deskripsi_kategori) ? null : $deskripsi_kategori,
                    ]);
                }

                if (!empty($kode_jenis) && !empty($nama_jenis)) {
                    $jenisExists = JenisLayanan::where('id_kategori', $kategori->id_kategori)
                        ->where('kode_jenis', $kode_jenis)
                        ->exists();
                    if (!$jenisExists) {
                        JenisLayanan::create([
                            'id_kategori' => $kategori->id_kategori,
                            'nama'        => $nama_jenis,
                            'kode_jenis'  => $kode_jenis,
                        ]);
                    }
                }
                $importedCount++;
            }
        });

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} data kategori/jenis. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} data kategori/jenis layanan.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_kategori_layanan.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['kode_kategori', 'nama_kategori', 'deskripsi_kategori', 'kode_jenis', 'nama_jenis']);
            fputcsv($file, ['PLT', 'Pelatihan K3', 'Program pelatihan kesehatan & keselamatan kerja', 'AK3U', 'Ahli K3 Umum']);
            fputcsv($file, ['PLT', 'Pelatihan K3', 'Program pelatihan kesehatan & keselamatan kerja', 'K3L', 'K3 Lingkungan Kerja']);
            fputcsv($file, ['KNS', 'Konsultasi K3', 'Layanan konsultasi dan pendampingan industri', 'ISO9001', 'Sistem Manajemen Mutu ISO']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
