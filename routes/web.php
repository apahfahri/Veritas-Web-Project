<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JadwalPublikController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PemateriController;
use App\Http\Controllers\Admin\LayananAdminController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\SertifikatAdminController;
use App\Http\Controllers\Admin\KlienMitraController;
use App\Http\Controllers\Admin\RiwayatPendaftaranController;
use App\Http\Controllers\Admin\LaporanMonitoringController;
use App\Http\Controllers\Admin\KategoriLayananController;
use App\Http\Controllers\RequestPelatihanController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $pemateris = \App\Models\Pemateri::all();
    return view('pages.home', compact('pemateris'));
})->name('home');
Route::redirect('/home', '/');

Route::view('/consultation', 'pages.consultation')->name('consultation');
Route::view('/audit', 'pages.audit')->name('audit');

/*
|--------------------------------------------------------------------------
| PELATIHAN & JADWAL (public)
|--------------------------------------------------------------------------
*/
Route::get('/training',                [JadwalPublikController::class, 'index'])->name('training.list');
Route::get('/training/status',         [PendaftaranController::class, 'statusForm'])->name('training.status');
Route::post('/training/status',        [PendaftaranController::class, 'checkStatus'])->name('training.status.check');
Route::get('/training/{id}',           [JadwalPublikController::class, 'show'])->name('training.detail');
Route::get('/training/{id}/register',  [JadwalPublikController::class, 'register'])->name('training.register');

Route::get('/request-training',  [RequestPelatihanController::class, 'create'])->name('request.training.create');
Route::post('/request-training', [RequestPelatihanController::class, 'store'])->name('request.training.store');
Route::redirect('/request-layanan', '/request-training');

/*
|--------------------------------------------------------------------------
| VERIFIKASI SERTIFIKAT (public)
|--------------------------------------------------------------------------
*/
Route::get('/verification',      [VerifikasiController::class, 'index'])->name('verification');
Route::post('/verification/cek', [VerifikasiController::class, 'cek'])->name('verification.cek');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Pendaftaran (Public POST)
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::post('/pendaftaran/verifikasi-nomor', [PendaftaranController::class, 'verifikasiNomor'])->name('pendaftaran.verifikasi-nomor');
Route::post('/pendaftaran/kirim-bukti', [PendaftaranController::class, 'kirimBuktiBayar'])->name('pendaftaran.kirim-bukti');
Route::post('/pendaftaran/{id}/cancel-user', [PendaftaranController::class, 'cancelByUser'])->name('pendaftaran.cancel-user');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL — AUTH + IS.ADMIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Pemateri CRUD
    Route::post('/petugas/import',     [PemateriController::class, 'import'])->name('petugas.import');
    Route::get('/petugas/import-template', [PemateriController::class, 'importTemplate'])->name('petugas.import-template');
    Route::get('/petugas',             [PemateriController::class, 'index'])->name('petugas.index');
    Route::get('/petugas/create',      [PemateriController::class, 'create'])->name('petugas.create');
    Route::post('/petugas',            [PemateriController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{id}/edit',   [PemateriController::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{id}',        [PemateriController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}',     [PemateriController::class, 'destroy'])->name('petugas.destroy');

    // Jadwal (Manajemen Program Layanan) — menggantikan /pelatihan
    Route::post('/jadwal/import',      [LayananAdminController::class, 'import'])->name('jadwal.import');
    Route::get('/jadwal/import-template', [LayananAdminController::class, 'importTemplate'])->name('jadwal.import-template');
    Route::get('/jadwal',              [LayananAdminController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create',       [LayananAdminController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal',             [LayananAdminController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}',         [LayananAdminController::class, 'show'])->name('jadwal.show');
    Route::post('/jadwal/{id}/resend', [LayananAdminController::class, 'resendReminder'])->name('jadwal.resend');
    Route::get('/jadwal/{id}/edit',    [LayananAdminController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}',         [LayananAdminController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}',      [LayananAdminController::class, 'destroy'])->name('jadwal.destroy');

    // Materi
    Route::post('/materi/import',          [\App\Http\Controllers\Admin\MateriController::class, 'import'])->name('materi.import');
    Route::get('/materi/import-template',  [\App\Http\Controllers\Admin\MateriController::class, 'importTemplate'])->name('materi.import-template');
    Route::resource('materi', \App\Http\Controllers\Admin\MateriController::class)->except(['show']);

    // Kategori & Jenis Layanan
    Route::post('/kategori/import',            [KategoriLayananController::class, 'import'])->name('kategori.import');
    Route::get('/kategori/import-template',    [KategoriLayananController::class, 'importTemplate'])->name('kategori.import-template');
    Route::get('/kategori',                    [KategoriLayananController::class, 'index'])->name('kategori.index');
    Route::post('/kategori',                   [KategoriLayananController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}',               [KategoriLayananController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}',            [KategoriLayananController::class, 'destroyKategori'])->name('kategori.destroy');
    Route::post('/kategori/jenis',             [KategoriLayananController::class, 'storeJenis'])->name('kategori.jenis.store');
    Route::put('/kategori/jenis/{id}',         [KategoriLayananController::class, 'updateJenis'])->name('kategori.jenis.update');
    Route::delete('/kategori/jenis/{id}',      [KategoriLayananController::class, 'destroyJenis'])->name('kategori.jenis.destroy');

    // Pendaftaran management
    Route::get('/pendaftaran',              [PendaftaranAdminController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/export/excel', [PendaftaranAdminController::class, 'exportExcel'])->name('pendaftaran.export-excel');
    Route::get('/pendaftaran/export/pdf',   [PendaftaranAdminController::class, 'exportPDF'])->name('pendaftaran.export-pdf');
    Route::get('/pendaftaran/{id}',         [PendaftaranAdminController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}',         [PendaftaranAdminController::class, 'update'])->name('pendaftaran.update');
    Route::get('/riwayat-pendaftaran',      [RiwayatPendaftaranController::class, 'index'])->name('riwayat.index');

    // Sertifikat management
    Route::post('/sertifikat/import',                   [SertifikatAdminController::class, 'import'])->name('sertifikat.import');
    Route::get('/sertifikat/import-template',           [SertifikatAdminController::class, 'importTemplate'])->name('sertifikat.import-template');
    Route::get('/sertifikat',                           [SertifikatAdminController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create/{id_pendaftaran}',   [SertifikatAdminController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat',                          [SertifikatAdminController::class, 'store'])->name('sertifikat.store');
    Route::get('/sertifikat/{no_sertifikat}',           [SertifikatAdminController::class, 'show'])->name('sertifikat.show');
    Route::get('/sertifikat/{no_sertifikat}/edit',      [SertifikatAdminController::class, 'edit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{no_sertifikat}',           [SertifikatAdminController::class, 'update'])->name('sertifikat.update');
    Route::delete('/sertifikat/{no_sertifikat}',        [SertifikatAdminController::class, 'destroy'])->name('sertifikat.destroy');
    Route::get('/laporan-monitoring',                   [LaporanMonitoringController::class, 'index'])->name('laporan.index');

    // Subadmin management
    Route::post('/subadmin/import',             [\App\Http\Controllers\Admin\SubadminController::class, 'import'])->name('subadmin.import');
    Route::get('/subadmin/import-template',     [\App\Http\Controllers\Admin\SubadminController::class, 'importTemplate'])->name('subadmin.import-template');
    Route::resource('subadmin', \App\Http\Controllers\Admin\SubadminController::class)->except(['show']);

    // Rekening management
    Route::resource('rekening', \App\Http\Controllers\Admin\RekeningController::class)->except(['show']);
    Route::post('/rekening/{id}/toggle', [\App\Http\Controllers\Admin\RekeningController::class, 'toggleActive'])->name('rekening.toggle');

    // Klien & Mitra (Perusahaan B2B)
    Route::post('/mitra/import',            [KlienMitraController::class, 'import'])->name('mitra.import');
    Route::get('/mitra/import-template',    [KlienMitraController::class, 'importTemplate'])->name('mitra.import-template');
    Route::resource('mitra', KlienMitraController::class)->except(['show']);


});

/*
|--------------------------------------------------------------------------
| SUBADMIN PANEL — AUTH + IS.SUBADMIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.subadmin'])->prefix('subadmin')->name('subadmin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Subadmin\SubadminDashboardController::class, 'index'])->name('dashboard');

    // Pendaftaran
    Route::get('/pendaftaran',                             [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}',                        [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}',                        [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::delete('/pendaftaran/{id}',                     [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
    Route::post('/pendaftaran/{id}/update-note',           [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'updateNote'])->name('pendaftaran.update-note');
    Route::post('/pendaftaran/{id}/upload-payment-proof',  [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'uploadPaymentProof'])->name('pendaftaran.upload-payment-proof');
    Route::post('/pendaftaran/{id}/konfirmasi-bukti',      [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'konfirmasiBukti'])->name('pendaftaran.konfirmasi-bukti');
    Route::post('/pendaftaran/{id}/batalkan',              [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'batalkanPendaftaran'])->name('pendaftaran.batalkan');
    Route::get('/pendaftaran-export/excel',                [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'exportExcel'])->name('pendaftaran.export-excel');

    // Jadwal (view & manage)
    Route::get('/jadwal',              [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create',       [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal',             [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}',         [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'show'])->name('jadwal.show');
    Route::post('/jadwal/{id}/resend', [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'resendReminder'])->name('jadwal.resend');
    Route::get('/jadwal/{id}/edit',    [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}',         [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}',      [\App\Http\Controllers\Subadmin\SubadminJadwalController::class, 'destroy'])->name('jadwal.destroy');



    // Perusahaan
    Route::get('/perusahaan',      [\App\Http\Controllers\Subadmin\SubadminPerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::get('/perusahaan/{id}', [\App\Http\Controllers\Subadmin\SubadminPerusahaanController::class, 'show'])->name('perusahaan.show');

    // Sertifikat
    Route::get('/sertifikat',                          [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create',                   [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'create'])->name('sertifikat.create-general');
    Route::get('/sertifikat/create/{pendaftaran_id}',  [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat',                         [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'store'])->name('sertifikat.store');
    Route::post('/sertifikat/import',                  [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'import'])->name('sertifikat.import');
    Route::get('/sertifikat/{no_sertifikat}/edit',     [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'edit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{no_sertifikat}',          [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'update'])->name('sertifikat.update');
    Route::delete('/sertifikat/{no_sertifikat}',       [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'destroy'])->name('sertifikat.destroy');

    // Materi
    Route::resource('materi', \App\Http\Controllers\Subadmin\MateriController::class)->except(['show']);

    // Pemateri (View Only)
    Route::get('/petugas', [\App\Http\Controllers\Subadmin\SubadminPetugasController::class, 'index'])->name('petugas.index');

    // Konsultasi
    Route::get('/konsultasi',                          [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/{id}',                     [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::post('/konsultasi/{id}/confirm',            [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'confirmConsultation'])->name('konsultasi.confirm');
    Route::post('/konsultasi/{id}/start-scheduling',   [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'startScheduling'])->name('konsultasi.start-scheduling');
    Route::post('/konsultasi/{id}/schedule',           [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'scheduleMeeting'])->name('konsultasi.schedule');
    Route::post('/konsultasi/{id}/finish',             [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'finishConsultation'])->name('konsultasi.finish');
    Route::post('/konsultasi/{id}/confirm-payment',    [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'confirmPayment'])->name('konsultasi.confirm-payment');
    Route::post('/konsultasi/{id}/reject-payment',     [\App\Http\Controllers\Subadmin\SubadminKonsultasiController::class, 'rejectPayment'])->name('konsultasi.reject-payment');

    // Audit
    Route::get('/audit-layanan',                       [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'index'])->name('audit.index');
    Route::get('/audit-layanan/{id}',                  [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'show'])->name('audit.show');
    Route::post('/audit-layanan/{id}/confirm',         [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'confirmAudit'])->name('audit.confirm');
    Route::post('/audit-layanan/{id}/start-scheduling',[\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'startScheduling'])->name('audit.start-scheduling');
    Route::post('/audit-layanan/{id}/schedule',        [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'scheduleMeeting'])->name('audit.schedule');
    Route::post('/audit-layanan/{id}/finish',          [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'finishAudit'])->name('audit.finish');
    Route::post('/audit-layanan/{id}/confirm-payment', [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'confirmPayment'])->name('audit.confirm-payment');
    Route::post('/audit-layanan/{id}/reject-payment',  [\App\Http\Controllers\Subadmin\SubadminAuditController::class, 'rejectPayment'])->name('audit.reject-payment');

    // Pelatihan Kustom (Bespoke/Request Lifecycle & Review)
    Route::get('/pelatihan-kustom',                          [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'index'])->name('pelatihan-kustom.index');
    Route::get('/pelatihan-kustom/{id}',                     [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'show'])->name('pelatihan-kustom.show');
    Route::post('/pelatihan-kustom/{id}/confirm',            [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'confirmRegistration'])->name('pelatihan-kustom.confirm');
    Route::post('/pelatihan-kustom/{id}/start-scheduling',   [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'startScheduling'])->name('pelatihan-kustom.start-scheduling');
    Route::post('/pelatihan-kustom/{id}/schedule',           [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'scheduleMeeting'])->name('pelatihan-kustom.schedule');
    Route::post('/pelatihan-kustom/{id}/finish',             [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'finishTraining'])->name('pelatihan-kustom.finish');
    Route::post('/pelatihan-kustom/{id}/confirm-payment',    [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'confirmPayment'])->name('pelatihan-kustom.confirm-payment');
    Route::post('/pelatihan-kustom/{id}/reject-payment',     [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'rejectPayment'])->name('pelatihan-kustom.reject-payment');
    Route::post('/pelatihan-kustom/{id}/add-participant',    [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'addParticipant'])->name('pelatihan-kustom.add-participant');
    Route::post('/pelatihan-kustom/{id}/import-participants',[\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'importParticipants'])->name('pelatihan-kustom.import-participants');
    Route::delete('/pelatihan-kustom/participant/{id}',      [\App\Http\Controllers\Subadmin\SubadminPelatihanKustomController::class, 'removeParticipant'])->name('pelatihan-kustom.remove-participant');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});