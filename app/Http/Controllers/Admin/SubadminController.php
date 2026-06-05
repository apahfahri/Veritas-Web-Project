<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubadminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isSuperAdmin()) {
                abort(403, 'Akses ditolak. Khusus Super Admin.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Ambil admin dengan role subadmin
        $admins = Admin::where('role', 'subadmin')->latest()->paginate(10);
        return view('admin.subadmin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.subadmin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username',
            'email'    => 'required|email|unique:admin,email',
            'password' => 'required|min:6',
            'no_telp'  => 'required|string|max:20',
            'status'   => 'required|in:aktif,nonaktif',
            'cabang'   => 'nullable|string|max:255',
        ]);

        Admin::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_telp'  => $request->no_telp,
            'role'     => 'subadmin',
            'status'   => $request->status,
            'cabang'   => $request->cabang,
        ]);

        return redirect()->route('admin.subadmin.index')
            ->with('success', 'Subadmin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.subadmin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username,' . $id . ',id_admin',
            'email'    => 'required|email|unique:admin,email,' . $id . ',id_admin',
            'password' => 'nullable|min:6',
            'no_telp'  => 'required|string|max:20',
            'status'   => 'required|in:aktif,nonaktif',
            'cabang'   => 'nullable|string|max:255',
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'no_telp'  => $request->no_telp,
            'status'   => $request->status,
            'cabang'   => $request->cabang,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.subadmin.index')
            ->with('success', 'Subadmin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.subadmin.index')
            ->with('success', 'Subadmin berhasil dihapus.');
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
                $username = trim($row['username'] ?? '');
                $email = trim($row['email'] ?? '');
                $password = trim($row['password'] ?? '');
                $no_telp = trim($row['no_telp'] ?? $row['telepon'] ?? $row['whatsapp'] ?? '');
                $status = strtolower(trim($row['status'] ?? 'aktif'));

                if (empty($username) || empty($email) || empty($password)) {
                    $errors[] = "Baris " . ($index + 2) . ": Username, Email, dan Password wajib diisi.";
                    continue;
                }

                // check unique username
                if (Admin::where('username', $username)->exists()) {
                    $errors[] = "Baris " . ($index + 2) . ": Username '{$username}' sudah digunakan.";
                    continue;
                }

                // check unique email
                if (Admin::where('email', $email)->exists()) {
                    $errors[] = "Baris " . ($index + 2) . ": Email '{$email}' sudah digunakan.";
                    continue;
                }

                Admin::create([
                    'username' => $username,
                    'email'    => $email,
                    'password' => Hash::make($password),
                    'no_telp'  => $no_telp,
                    'role'     => 'subadmin',
                    'status'   => in_array($status, ['aktif', 'nonaktif']) ? $status : 'aktif',
                ]);
                $importedCount++;
            }
        });

        if (count($errors) > 0) {
            $msg = "Berhasil mengimpor {$importedCount} subadmin. Beberapa baris dilewati:\n" . implode("\n", $errors);
            return back()->with('warning', $msg);
        }

        return back()->with('success', "Berhasil mengimpor {$importedCount} akun subadmin.");
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_subadmin.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['username', 'email', 'password', 'no_telp', 'status']);
            fputcsv($file, ['subadmin_john', 'john.doe@example.com', 'password123', '081234567890', 'aktif']);
            fputcsv($file, ['subadmin_jane', 'jane.doe@example.com', 'securepass', '089876543210', 'nonaktif']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
