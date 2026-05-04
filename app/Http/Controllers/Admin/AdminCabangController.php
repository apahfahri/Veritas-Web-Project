<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminCabangController extends Controller
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
        // Hanya ambil admin yang rolenya 'admin' (bukan superadmin)
        $admins = Admin::with('user')->where('role', 'admin')->latest()->paginate(10);
        return view('admin.admin-cabang.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-cabang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Admin::create([
            'user_id' => $user->id,
            'role'    => 'admin',
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.admin-cabang.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = Admin::with('user')->findOrFail($id);
        return view('admin.admin-cabang.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->user_id,
            'password' => 'nullable|min:6',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        $userData = [
            'username' => $request->username,
            'email'    => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $admin->user->update($userData);

        $admin->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.admin-cabang.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $user = $admin->user;
        $admin->delete();
        $user->delete();

        return redirect()->route('admin.admin-cabang.index')
            ->with('success', 'Admin Cabang berhasil dihapus.');
    }
}
