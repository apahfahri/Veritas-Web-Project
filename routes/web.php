<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PemateriController;
use App\Http\Controllers\Admin\LayananAdminController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\SertifikatAdminController;
use App\Http\Controllers\RequestPelatihanController;


/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/', function() {
    $pemateris = \App\Models\Pemateri::all();
    return view('pages.home', compact('pemateris'));
})->name('home');
Route::redirect('/home', '/');

Route::view('/consultation', 'pages.consultation')->name('consultation');
Route::view('/audit', 'pages.audit')->name('audit');

/*
|--------------------------------------------------------------------------
| PELATIHAN (public)
|--------------------------------------------------------------------------
*/
Route::get('/training',              [PelatihanController::class, 'index'])->name('training.list');
Route::get('/training/status',       [PendaftaranController::class, 'statusForm'])->name('training.status');
Route::post('/training/status',      [PendaftaranController::class, 'checkStatus'])->name('training.status.check');
Route::get('/training/{id}',         [PelatihanController::class, 'show'])->name('training.detail');
Route::get('/training/{id}/register',  [PelatihanController::class, 'register'])->name('training.register');

Route::get('/request-training',      [RequestPelatihanController::class, 'create'])->name('request.training.create');
Route::post('/request-training',     [RequestPelatihanController::class, 'store'])->name('request.training.store');


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
    Route::get('/login',     [LoginController::class,    'showForm'])->name('login');
    Route::post('/login',    [LoginController::class,    'login']);

    // User Auth Routes Removed
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Pendaftaran (Public)
Route::post('/pendaftaran', [\App\Http\Controllers\PendaftaranController::class, 'store'])->name('pendaftaran.store');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL — AUTH + IS.ADMIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',  [AdminDashboardController::class, 'index'])->name('dashboard');

    // Pemateri CRUD
    Route::get('/petugas',             [PemateriController::class, 'index'])->name('petugas.index');
    Route::get('/petugas/create',      [PemateriController::class, 'create'])->name('petugas.create');
    Route::post('/petugas',            [PemateriController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{id}/edit',   [PemateriController::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{id}',        [PemateriController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}',     [PemateriController::class, 'destroy'])->name('petugas.destroy');

    // Layanan CRUD
    Route::get('/pelatihan',           [LayananAdminController::class, 'index'])->name('pelatihan.index');
    Route::get('/pelatihan/create',    [LayananAdminController::class, 'create'])->name('pelatihan.create');
    Route::post('/pelatihan',          [LayananAdminController::class, 'store'])->name('pelatihan.store');
    Route::get('/pelatihan/{id}/edit', [LayananAdminController::class, 'edit'])->name('pelatihan.edit');
    Route::put('/pelatihan/{id}',      [LayananAdminController::class, 'update'])->name('pelatihan.update');
    Route::delete('/pelatihan/{id}',   [LayananAdminController::class, 'destroy'])->name('pelatihan.destroy');

    // Pendaftaran management
    Route::get('/pendaftaran',         [PendaftaranAdminController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}',    [PendaftaranAdminController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}',    [PendaftaranAdminController::class, 'update'])->name('pendaftaran.update');

    // Sertifikat management
    Route::get('/sertifikat',                          [SertifikatAdminController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create/{pendaftaran_id}',  [SertifikatAdminController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat',                         [SertifikatAdminController::class, 'store'])->name('sertifikat.store');

    // Subadmin management (Superadmin only)
    Route::resource('subadmin', \App\Http\Controllers\Admin\SubadminController::class)->except(['show']);

    // Kategori & Jenis Layanan management
    Route::get('/kategori', [\App\Http\Controllers\Admin\KategoriLayananController::class, 'index'])->name('kategori.index');
    Route::post('/kategori/jenis', [\App\Http\Controllers\Admin\KategoriLayananController::class, 'storeJenis'])->name('kategori.jenis.store');
    Route::put('/kategori/jenis/{id}', [\App\Http\Controllers\Admin\KategoriLayananController::class, 'updateJenis'])->name('kategori.jenis.update');
    Route::delete('/kategori/jenis/{id}', [\App\Http\Controllers\Admin\KategoriLayananController::class, 'destroyJenis'])->name('kategori.jenis.destroy');
});

/*
|--------------------------------------------------------------------------
| SUBADMIN PANEL — AUTH + IS.SUBADMIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.subadmin'])->prefix('subadmin')->name('subadmin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Subadmin\SubadminDashboardController::class, 'index'])->name('dashboard');

    // Pendaftaran
    Route::get('/pendaftaran', [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}', [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}', [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::delete('/pendaftaran/{id}', [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
    Route::post('/pendaftaran/{id}/send-reminder', [\App\Http\Controllers\Subadmin\SubadminPendaftaranController::class, 'sendReminder'])->name('pendaftaran.send-reminder');

    // Klien
    Route::get('/klien', [\App\Http\Controllers\Subadmin\SubadminKlienController::class, 'index'])->name('klien.index');
    Route::get('/klien/{id}', [\App\Http\Controllers\Subadmin\SubadminKlienController::class, 'show'])->name('klien.show');
    Route::delete('/klien/{id}', [\App\Http\Controllers\Subadmin\SubadminKlienController::class, 'destroy'])->name('klien.destroy');

    // Sertifikat
    Route::get('/sertifikat', [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create/{pendaftaran_id}', [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat', [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'store'])->name('sertifikat.store');
    Route::get('/sertifikat/{no_sertifikat}/edit', [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'edit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{no_sertifikat}', [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'update'])->name('subadmin.sertifikat.update');
    Route::delete('/sertifikat/{no_sertifikat}', [\App\Http\Controllers\Subadmin\SubadminSertifikatController::class, 'destroy'])->name('sertifikat.destroy');

    // Pelatihan (View Only)
    Route::get('/pelatihan', [\App\Http\Controllers\Subadmin\SubadminLayananController::class, 'index'])->name('pelatihan.index');

    // Petugas (View Only)
    Route::get('/petugas', [\App\Http\Controllers\Subadmin\SubadminPemateriController::class, 'index'])->name('petugas.index');

    // Layanan (View Only)
    Route::get('/layanan', [\App\Http\Controllers\Subadmin\SubadminLayananController::class, 'index'])->name('layanan.index');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});