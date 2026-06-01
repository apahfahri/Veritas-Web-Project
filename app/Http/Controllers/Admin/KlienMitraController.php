<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlienPerusahaan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlienMitraController extends Controller
{
    /**
     * Daftar seluruh mitra perusahaan.
     */
    public function index(Request $request)
    {
        $query = Perusahaan::with(['klienPerusahaan.user'])->latest('id_perusahaan');

        // Search berdasarkan nama perusahaan atau nama CP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('klienPerusahaan.user', function ($u) use ($search) {
                      $u->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('klienPerusahaan', function ($kp) use ($search) {
                      $kp->where('nama_cp', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan sektor industri
        if ($request->filled('sektor')) {
            $query->where('sektor_industri', $request->sektor);
        }

        $mitras    = $query->paginate(10)->withQueryString();
        $sektors   = Perusahaan::select('sektor_industri')
                        ->whereNotNull('sektor_industri')
                        ->distinct()
                        ->orderBy('sektor_industri')
                        ->pluck('sektor_industri');

        return view('admin.mitra.index', compact('mitras', 'sektors'));
    }

    /**
     * Tampilkan form tambah mitra baru.
     */
    public function create()
    {
        return view('admin.mitra.create');
    }

    /**
     * Tampilkan form edit mitra.
     */
    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $cp = $perusahaan->klienPerusahaan()->first();
        return view('admin.mitra.edit', compact('perusahaan', 'cp'));
    }

    /**
     * Simpan mitra baru (perusahaan + klien_perusahaan).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'alamat'          => 'nullable|string|max:500',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer|min:0',
            'jabatan'         => 'nullable|string|max:255',
            'nama_cp'         => 'nullable|string|max:255',
            'no_hp_cp'        => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $perusahaan = Perusahaan::create([
                'nama'            => $request->nama,
                'alamat'          => $request->alamat,
                'sektor_industri' => $request->sektor_industri,
                'jumlah_karyawan' => $request->jumlah_karyawan,
            ]);

            // Buat entri CP manual (id_user null = diinput admin)
            KlienPerusahaan::create([
                'id_perusahaan' => $perusahaan->id_perusahaan,
                'id_user'       => null,
                'jabatan'       => $request->jabatan,
                'nama_cp'       => $request->nama_cp,
                'no_hp_cp'      => $request->no_hp_cp,
            ]);
        });

        return redirect()->route('admin.mitra.index')
            ->with('success', "Mitra perusahaan \"{$request->nama}\" berhasil ditambahkan.");
    }

    /**
     * Update data mitra.
     */
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'alamat'          => 'nullable|string|max:500',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer|min:0',
            'jabatan'         => 'nullable|string|max:255',
            'nama_cp'         => 'nullable|string|max:255',
            'no_hp_cp'        => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $perusahaan) {
            $perusahaan->update([
                'nama'            => $request->nama,
                'alamat'          => $request->alamat,
                'sektor_industri' => $request->sektor_industri,
                'jumlah_karyawan' => $request->jumlah_karyawan,
            ]);

            // Ambil CP pertama (bisa dari user terdaftar atau manual)
            $cp = $perusahaan->klienPerusahaan()->first();

            if ($cp) {
                // Preserve id_user yang sudah ada — hanya update jabatan & info manual
                $cp->update([
                    'jabatan'  => $request->jabatan,
                    'nama_cp'  => $request->nama_cp,
                    'no_hp_cp' => $request->no_hp_cp,
                ]);
            } else {
                // Buat CP baru jika belum ada
                KlienPerusahaan::create([
                    'id_perusahaan' => $perusahaan->id_perusahaan,
                    'id_user'       => null,
                    'jabatan'       => $request->jabatan,
                    'nama_cp'       => $request->nama_cp,
                    'no_hp_cp'      => $request->no_hp_cp,
                ]);
            }
        });

        return redirect()->route('admin.mitra.index')
            ->with('success', "Data mitra \"{$perusahaan->nama}\" berhasil diperbarui.");
    }

    /**
     * Hapus mitra (klien_perusahaan dulu, lalu perusahaan).
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        DB::transaction(function () use ($perusahaan) {
            $perusahaan->klienPerusahaan()->delete();
            $perusahaan->delete();
        });

        return redirect()->route('admin.mitra.index')
            ->with('success', "Mitra perusahaan berhasil dihapus.");
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
                $nama = trim($row['nama_perusahaan'] ?? $row['nama'] ?? '');
                $alamat = trim($row['alamat'] ?? '');
                $sektor_industri = trim($row['sektor_industri'] ?? '');
                $jumlah_karyawan = trim($row['jumlah_karyawan'] ?? '0');
                $nama_cp = trim($row['nama_cp'] ?? '');
                $no_hp_cp = trim($row['no_hp_cp'] ?? $row['no_telp_cp'] ?? $row['telp_cp'] ?? '');
                $jabatan = trim($row['jabatan'] ?? '');

                if (empty($nama)) {
                    $errors[] = "Baris " . ($index + 2) . ": Nama perusahaan wajib diisi.";
                    continue;
                }

                $perusahaan = Perusahaan::where('nama', $nama)->first();
                if (!$perusahaan) {
                    $perusahaan = Perusahaan::create([
                        'nama'            => $nama,
                        'alamat'          => empty($alamat) ? null : $alamat,
                        'sektor_industri' => empty($sektor_industri) ? null : $sektor_industri,
                        'jumlah_karyawan' => is_numeric($jumlah_karyawan) ? intval($jumlah_karyawan) : 0,
                    ]);
                } else {
                    $perusahaan->update([
                        'alamat'          => empty($alamat) ? $perusahaan->alamat : $alamat,
                        'sektor_industri' => empty($sektor_industri) ? $perusahaan->sektor_industri : $sektor_industri,
                        'jumlah_karyawan' => is_numeric($jumlah_karyawan) ? intval($jumlah_karyawan) : $perusahaan->jumlah_karyawan,
                    ]);
                }

                if (!empty($nama_cp)) {
                    $cp = $perusahaan->klienPerusahaan()->first();
                    if ($cp) {
                        $cp->update([
                            'nama_cp'  => $nama_cp,
                            'no_hp_cp' => empty($no_hp_cp) ? $cp->no_hp_cp : $no_hp_cp,
                            'jabatan'  => empty($jabatan) ? $cp->jabatan : $jabatan,
                        ]);
                    } else {
                        KlienPerusahaan::create([
                            'id_perusahaan' => $perusahaan->id_perusahaan,
                            'id_user'       => null,
                            'jabatan'       => empty($jabatan) ? null : $jabatan,
                            'nama_cp'       => $nama_cp,
                            'no_hp_cp'      => empty($no_hp_cp) ? null : $no_hp_cp,
                        ]);
                    }
                }
                $importedCount++;
            }
        });

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} mitra. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} mitra perusahaan.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_mitra.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['nama_perusahaan', 'alamat', 'sektor_industri', 'jumlah_karyawan', 'nama_cp', 'no_hp_cp', 'jabatan']);
            fputcsv($file, ['PT Krakatau Steel', 'Jl. Industri No. 5 Cilegon', 'Manufaktur & Baja', '2500', 'Bambang Tri', '081234567890', 'HR Manager']);
            fputcsv($file, ['PT Pertamina (Persero)', 'Jl. Medan Merdeka Timur Jakarta', 'Energi & Migas', '15000', 'Siti Rahma', '089876543210', 'Head of HSE']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
