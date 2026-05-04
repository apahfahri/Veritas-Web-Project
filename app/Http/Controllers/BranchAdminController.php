<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class BranchAdminController extends Controller
{
    /**
     * Dashboard view specific to logged-in Admin's branch.
     */
    public function dashboard()
    {
        $cabang = Auth::user()->adminCabang();

        // Get stats for this branch
        $stats = [
            'cabang'        => strtoupper($cabang),
            'total_layanan' => Layanan::where('cabang', $cabang)->count(),
            'total_klien'   => Perusahaan::where('cabang', $cabang)->count(),
            'total_peserta' => Pendaftaran::where('cabang', $cabang)->count(),
            'total_jadwal'  => Pelatihan::where('cabang', $cabang)->count(),
            'total_sertifikat' => Sertifikat::where('cabang', $cabang)->count(),
        ];

        return view('admin.branch.dashboard', compact('stats'));
    }

    /*
    |--------------------------------------------------------------------------
    | FR-02: LAYANAN (SERVICES)
    |--------------------------------------------------------------------------
    */
    public function layanan()
    {
        $cabang = Auth::user()->adminCabang();
        $layanan = Layanan::where('cabang', $cabang)->get();
        return view('admin.branch.layanan', compact('layanan'));
    }

    public function layananStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $cabang = Auth::user()->adminCabang();

        Layanan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'cabang' => $cabang,
        ]);

        return redirect()->back()->with('success', 'Layanan berhasil ditambahkan ke cabang Anda.');
    }

    public function layananEdit($id)
    {
        $cabang = Auth::user()->adminCabang();
        $layanan = Layanan::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        return view('admin.branch.layanan-edit', compact('layanan'));
    }

    public function layananUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $cabang = Auth::user()->adminCabang();
        $layanan = Layanan::where('cabang', $cabang)->where('id', $id)->firstOrFail();

        $layanan->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('branch-admin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function layananDelete($id)
    {
        $cabang = Auth::user()->adminCabang();
        $layanan = Layanan::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $layanan->delete();

        return redirect()->back()->with('success', 'Layanan berhasil dihapus dari cabang Anda.');
    }

    /*
    |--------------------------------------------------------------------------
    | FR-03: KLIEN/MITRA (CLIENTS/PARTNERS)
    |--------------------------------------------------------------------------
    */
    public function klien()
    {
        $cabang = Auth::user()->adminCabang();
        $klien = Perusahaan::where('cabang', $cabang)->get();
        return view('admin.branch.klien', compact('klien'));
    }

    public function klienStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nib_oss' => 'nullable|string|max:255',
            'npwp_perusahaan' => 'nullable|string|max:255',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer',
        ]);

        $cabang = Auth::user()->adminCabang();

        Perusahaan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nib_oss' => $request->nib_oss,
            'npwp_perusahaan' => $request->npwp_perusahaan,
            'sektor_industri' => $request->sektor_industri,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'cabang' => $cabang,
        ]);

        return redirect()->back()->with('success', 'Klien/Mitra berhasil ditambahkan.');
    }

    public function klienEdit($id)
    {
        $cabang = Auth::user()->adminCabang();
        $klien = Perusahaan::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        return view('admin.branch.klien-edit', compact('klien'));
    }

    public function klienUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nib_oss' => 'nullable|string|max:255',
            'npwp_perusahaan' => 'nullable|string|max:255',
            'sektor_industri' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer',
        ]);

        $cabang = Auth::user()->adminCabang();
        $klien = Perusahaan::where('cabang', $cabang)->where('id', $id)->firstOrFail();

        $klien->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nib_oss' => $request->nib_oss,
            'npwp_perusahaan' => $request->npwp_perusahaan,
            'sektor_industri' => $request->sektor_industri,
            'jumlah_karyawan' => $request->jumlah_karyawan,
        ]);

        return redirect()->route('branch-admin.klien.index')->with('success', 'Klien/Mitra berhasil diperbarui.');
    }

    public function klienDelete($id)
    {
        $cabang = Auth::user()->adminCabang();
        $klien = Perusahaan::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $klien->delete();

        return redirect()->back()->with('success', 'Klien/Mitra berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | FR-04: PESERTA & RIWAYAT LAYANAN (PARTICIPANTS & SERVICE HISTORY)
    |--------------------------------------------------------------------------
    */
    public function peserta()
    {
        $cabang = Auth::user()->adminCabang();
        $peserta = Pendaftaran::where('cabang', $cabang)->with(['user', 'layanan'])->get();
        $layanan = Layanan::where('cabang', $cabang)->get();
        $users = User::all(); // To pick which user is registering

        return view('admin.branch.peserta', compact('peserta', 'layanan', 'users'));
    }

    public function pesertaStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'layanan_id' => 'required|exists:layanan,id',
            'tanggal_daftar' => 'required|date',
            'status_progres' => 'required|in:menunggu,diproses,selesai,dibatalkan',
            'status_bayar' => 'required|in:belum_bayar,menunggu_konfirmasi,lunas',
        ]);

        $cabang = Auth::user()->adminCabang();

        Pendaftaran::create([
            'user_id' => $request->user_id,
            'layanan_id' => $request->layanan_id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_progres' => $request->status_progres,
            'status_bayar' => $request->status_bayar,
            'cabang' => $cabang,
        ]);

        return redirect()->back()->with('success', 'Data peserta/riwayat berhasil ditambahkan.');
    }

    public function pesertaEdit($id)
    {
        $cabang = Auth::user()->adminCabang();
        $peserta = Pendaftaran::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $layanan = Layanan::where('cabang', $cabang)->get();
        $users = User::all();

        return view('admin.branch.peserta-edit', compact('peserta', 'layanan', 'users'));
    }

    public function pesertaUpdate(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'layanan_id' => 'required|exists:layanan,id',
            'tanggal_daftar' => 'required|date',
            'status_progres' => 'required|in:menunggu,diproses,selesai,dibatalkan',
            'status_bayar' => 'required|in:belum_bayar,menunggu_konfirmasi,lunas',
        ]);

        $cabang = Auth::user()->adminCabang();
        $peserta = Pendaftaran::where('cabang', $cabang)->where('id', $id)->firstOrFail();

        $peserta->update([
            'user_id' => $request->user_id,
            'layanan_id' => $request->layanan_id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_progres' => $request->status_progres,
            'status_bayar' => $request->status_bayar,
        ]);

        return redirect()->route('branch-admin.peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function pesertaDelete($id)
    {
        $cabang = Auth::user()->adminCabang();
        $peserta = Pendaftaran::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $peserta->delete();

        return redirect()->back()->with('success', 'Data peserta berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | FR-05: JADWAL PELATIHAN/AUDIT (SCHEDULES)
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        $cabang = Auth::user()->adminCabang();
        $jadwal = Pelatihan::where('cabang', $cabang)->with('layanan')->get();
        $layanan = Layanan::where('cabang', $cabang)->get();

        return view('admin.branch.jadwal', compact('jadwal', 'layanan'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'materi' => 'required|string|max:255',
            'jenis_pertemuan' => 'required|string|in:online,offline',
            'jam_pertemuan' => 'nullable',
            'tanggal_pertemuan' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $cabang = Auth::user()->adminCabang();

        Pelatihan::create([
            'layanan_id' => $request->layanan_id,
            'materi' => $request->materi,
            'jenis_pertemuan' => $request->jenis_pertemuan,
            'jam_pertemuan' => $request->jam_pertemuan,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'deskripsi' => $request->deskripsi,
            'cabang' => $cabang,
        ]);

        return redirect()->back()->with('success', 'Jadwal pelatihan berhasil ditambahkan.');
    }

    public function jadwalEdit($id)
    {
        $cabang = Auth::user()->adminCabang();
        $jadwal = Pelatihan::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $layanan = Layanan::where('cabang', $cabang)->get();

        return view('admin.branch.jadwal-edit', compact('jadwal', 'layanan'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'materi' => 'required|string|max:255',
            'jenis_pertemuan' => 'required|string|in:online,offline',
            'jam_pertemuan' => 'nullable',
            'tanggal_pertemuan' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $cabang = Auth::user()->adminCabang();
        $jadwal = Pelatihan::where('cabang', $cabang)->where('id', $id)->firstOrFail();

        $jadwal->update([
            'layanan_id' => $request->layanan_id,
            'materi' => $request->materi,
            'jenis_pertemuan' => $request->jenis_pertemuan,
            'jam_pertemuan' => $request->jam_pertemuan,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('branch-admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function jadwalDelete($id)
    {
        $cabang = Auth::user()->adminCabang();
        $jadwal = Pelatihan::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | FR-06: SERTIFIKAT (CERTIFICATES)
    |--------------------------------------------------------------------------
    */
    public function sertifikat()
    {
        $cabang = Auth::user()->adminCabang();
        $sertifikat = Sertifikat::where('cabang', $cabang)->with('pendaftaran.user')->get();
        $pendaftaran = Pendaftaran::where('cabang', $cabang)->with('user')->get();

        return view('admin.branch.sertifikat', compact('sertifikat', 'pendaftaran'));
    }

    public function sertifikatStore(Request $request)
    {
        $request->validate([
            'no_sertifikat' => 'required|string|unique:sertifikat,no_sertifikat',
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'file' => 'nullable|string',
        ]);

        $cabang = Auth::user()->adminCabang();

        Sertifikat::create([
            'no_sertifikat' => $request->no_sertifikat,
            'pendaftaran_id' => $request->pendaftaran_id,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'file' => $request->file,
            'cabang' => $cabang,
        ]);

        return redirect()->back()->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function sertifikatEdit($id)
    {
        $cabang = Auth::user()->adminCabang();
        $sertifikat = Sertifikat::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $pendaftaran = Pendaftaran::where('cabang', $cabang)->get();

        return view('admin.branch.sertifikat-edit', compact('sertifikat', 'pendaftaran'));
    }

    public function sertifikatUpdate(Request $request, $id)
    {
        $request->validate([
            'no_sertifikat' => 'required|string|unique:sertifikat,no_sertifikat,' . $id,
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'file' => 'nullable|string',
        ]);

        $cabang = Auth::user()->adminCabang();
        $sertifikat = Sertifikat::where('cabang', $cabang)->where('id', $id)->firstOrFail();

        $sertifikat->update([
            'no_sertifikat' => $request->no_sertifikat,
            'pendaftaran_id' => $request->pendaftaran_id,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'file' => $request->file,
        ]);

        return redirect()->route('branch-admin.sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function sertifikatDelete($id)
    {
        $cabang = Auth::user()->adminCabang();
        $sertifikat = Sertifikat::where('cabang', $cabang)->where('id', $id)->firstOrFail();
        $sertifikat->delete();

        return redirect()->back()->with('success', 'Sertifikat berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | FR-07: LAPORAN STATISTIK (REPORTS)
    |--------------------------------------------------------------------------
    */
    public function laporan(Request $request)
    {
        $cabang = Auth::user()->adminCabang();
        
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan');

        $query = Pendaftaran::where('cabang', $cabang)->whereYear('tanggal_daftar', $tahun);
        if ($bulan) {
            $query->whereMonth('tanggal_daftar', $bulan);
        }

        $pendaftaran = $query->with(['user', 'layanan'])->get();

        return view('admin.branch.laporan', compact('pendaftaran', 'tahun', 'bulan'));
    }
}
