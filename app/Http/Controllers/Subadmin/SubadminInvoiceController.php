<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $settings = InvoiceSetting::getSettings();
        return view('subadmin.invoice.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'rekening_1_bank' => 'required|string|max:255',
            'rekening_1_nomor' => 'required|string|max:255',
            'rekening_1_atas_nama' => 'required|string|max:255',
            'rekening_2_bank' => 'nullable|string|max:255',
            'rekening_2_nomor' => 'nullable|string|max:255',
            'rekening_2_atas_nama' => 'nullable|string|max:255',
            'rekening_aktif' => 'required|in:1,2',
            'catatan_invoice' => 'nullable|string|max:1000',
        ]);

        $settings = InvoiceSetting::getSettings();

        $settings->update([
            'rekening_1_bank' => $request->rekening_1_bank,
            'rekening_1_nomor' => $request->rekening_1_nomor,
            'rekening_1_atas_nama' => $request->rekening_1_atas_nama,
            'rekening_1_aktif' => $request->rekening_aktif == '1',
            'rekening_2_bank' => $request->rekening_2_bank,
            'rekening_2_nomor' => $request->rekening_2_nomor,
            'rekening_2_atas_nama' => $request->rekening_2_atas_nama,
            'rekening_2_aktif' => $request->rekening_aktif == '2',
            'catatan_invoice' => $request->catatan_invoice,
        ]);

        return redirect()->route('subadmin.invoice.index')
            ->with('success', 'Pengaturan invoice berhasil diperbarui.');
    }
}
