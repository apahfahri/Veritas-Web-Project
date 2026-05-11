<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        ]);

        Admin::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_telp'  => $request->no_telp,
            'role'     => 'subadmin',
            'status'   => $request->status,
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
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'no_telp'  => $request->no_telp,
            'status'   => $request->status,
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
}
