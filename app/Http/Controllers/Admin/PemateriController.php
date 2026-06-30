<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PemateriController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemateri::with(['jadwals.jenis', 'jadwals.kategori'])->latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('kompetensi', 'like', "%{$search}%");
            });
        }
        $pemateris = $query->paginate(5)->withQueryString();
        return view('admin.petugas.index', compact('pemateris'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kompetensi'   => 'nullable|string',
            'bio'          => 'nullable|string',
            'no_telp'      => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::slug($request->nama_lengkap) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pemateri', $filename, 'public');
            $data['foto'] = $path;
        }

        Pemateri::create($data);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pemateri = Pemateri::findOrFail($id);
        return view('admin.petugas.edit', compact('pemateri'));
    }

    public function update(Request $request, $id)
    {
        $pemateri = Pemateri::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kompetensi'   => 'nullable|string',
            'bio'          => 'nullable|string',
            'no_telp'      => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pemateri->foto) {
                Storage::disk('public')->delete($pemateri->foto);
            }

            $file = $request->file('foto');
            $filename = Str::slug($request->nama_lengkap) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pemateri', $filename, 'public');
            $data['foto'] = $path;
        }

        $pemateri->update($data);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemateri = Pemateri::findOrFail($id);
        
        // Hapus foto jika ada
        if ($pemateri->foto) {
            Storage::disk('public')->delete($pemateri->foto);
        }

        $pemateri->jadwals()->detach();
        $pemateri->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Pemateri berhasil dihapus.');
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
                $nama_lengkap = trim($row['nama_lengkap'] ?? $row['nama'] ?? '');
                $email = trim($row['email'] ?? '');
                $no_telp = trim($row['no_telp'] ?? $row['telepon'] ?? $row['whatsapp'] ?? $row['no_hp'] ?? '');
                $kompetensi = trim($row['kompetensi'] ?? '');
                $bio = trim($row['bio'] ?? '');

                if (empty($nama_lengkap)) {
                    $errors[] = "Baris " . ($index + 2) . ": Nama Lengkap wajib diisi.";
                    continue;
                }

                if (!empty($email) && Pemateri::where('email', $email)->exists()) {
                    $errors[] = "Baris " . ($index + 2) . ": Email pemateri '{$email}' sudah terdaftar.";
                    continue;
                }

                Pemateri::create([
                    'nama_lengkap' => $nama_lengkap,
                    'email'        => empty($email) ? null : $email,
                    'no_telp'      => empty($no_telp) ? null : $no_telp,
                    'kompetensi'   => empty($kompetensi) ? null : $kompetensi,
                    'bio'          => empty($bio) ? null : $bio,
                ]);
                $importedCount++;
            }
        });

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} pemateri. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} pemateri.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_pemateri.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['nama_lengkap', 'email', 'no_telp', 'kompetensi', 'bio']);
            fputcsv($file, ['Dr. John Doe', 'john.doe@example.com', '081234567890', 'Ahli K3 Konstruksi', 'Berpengalaman 15 tahun di industri konstruksi global.']);
            fputcsv($file, ['Jane Smith, M.Si', 'jane.smith@example.com', '089876543210', 'Spesialis K3 Lingkungan Kerja', 'Konsultan senior dan pengajar bersertifikasi BNSP.']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
