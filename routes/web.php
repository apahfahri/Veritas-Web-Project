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
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\PelatihanAdminController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\SertifikatAdminController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::view('/', 'pages.home')->name('home');
Route::redirect('/home', '/');

Route::view('/consultation', 'pages.consultation')->name('consultation');
Route::view('/audit', 'pages.audit')->name('audit');

/*
|--------------------------------------------------------------------------
| PELATIHAN (public)
|--------------------------------------------------------------------------
*/
Route::get('/training',              [PelatihanController::class, 'index'])->name('training.list');
Route::get('/training/{id}',         [PelatihanController::class, 'show'])->name('training.detail');
Route::get('/training/{id}/register',  [PelatihanController::class, 'register'])->name('training.register');

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

    // Register + OTP Verifikasi
    Route::get('/register',              [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register',             [RegisterController::class, 'register']);
    Route::get('/register/otp',          [RegisterController::class, 'showOtp'])->name('register.otp');
    Route::post('/register/otp/verify',  [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
    Route::post('/register/otp/resend',  [RegisterController::class, 'resendOtp'])->name('register.otp.resend');

    // Lupa Password
    Route::get('/forgot-password',              [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password',             [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/forgot-password/otp',          [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
    Route::post('/forgot-password/otp/verify',  [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::post('/forgot-password/otp/resend',  [ForgotPasswordController::class, 'resendOtp'])->name('password.otp.resend');
    Route::get('/forgot-password/reset',        [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/forgot-password/reset',       [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| USER — AUTH REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pendaftaran
    Route::post('/pendaftaran',         [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::delete('/pendaftaran/{id}',  [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL — AUTH + IS.ADMIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',  [AdminDashboardController::class, 'index'])->name('dashboard');

    // Petugas CRUD
    Route::get('/petugas',             [PetugasController::class, 'index'])->name('petugas.index');
    Route::get('/petugas/create',      [PetugasController::class, 'create'])->name('petugas.create');
    Route::post('/petugas',            [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{id}/edit',   [PetugasController::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{id}',        [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}',     [PetugasController::class, 'destroy'])->name('petugas.destroy');

    // Pelatihan CRUD
    Route::get('/pelatihan',           [PelatihanAdminController::class, 'index'])->name('pelatihan.index');
    Route::get('/pelatihan/create',    [PelatihanAdminController::class, 'create'])->name('pelatihan.create');
    Route::post('/pelatihan',          [PelatihanAdminController::class, 'store'])->name('pelatihan.store');
    Route::get('/pelatihan/{id}/edit', [PelatihanAdminController::class, 'edit'])->name('pelatihan.edit');
    Route::put('/pelatihan/{id}',      [PelatihanAdminController::class, 'update'])->name('pelatihan.update');
    Route::delete('/pelatihan/{id}',   [PelatihanAdminController::class, 'destroy'])->name('pelatihan.destroy');

    // Pendaftaran management
    Route::get('/pendaftaran',         [PendaftaranAdminController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}',    [PendaftaranAdminController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}',    [PendaftaranAdminController::class, 'update'])->name('pendaftaran.update');

    // Sertifikat management
    Route::get('/sertifikat',                          [SertifikatAdminController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create/{pendaftaran_id}',  [SertifikatAdminController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat',                         [SertifikatAdminController::class, 'store'])->name('sertifikat.store');

    // Admin Cabang management (Superadmin only)
    Route::resource('admin-cabang', \App\Http\Controllers\Admin\AdminCabangController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| BRANCH ADMIN PANEL — AUTH + IS.BRANCH_ADMIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.branch_admin'])->prefix('branch-admin')->name('branch-admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\BranchAdminController::class, 'dashboard'])->name('dashboard');

    // Layanan (FR-02)
    Route::get('/layanan', [App\Http\Controllers\BranchAdminController::class, 'layanan'])->name('layanan.index');
    Route::post('/layanan', [App\Http\Controllers\BranchAdminController::class, 'layananStore'])->name('layanan.store');
    Route::get('/layanan/{id}/edit', [App\Http\Controllers\BranchAdminController::class, 'layananEdit'])->name('layanan.edit');
    Route::put('/layanan/{id}', [App\Http\Controllers\BranchAdminController::class, 'layananUpdate'])->name('layanan.update');
    Route::delete('/layanan/{id}', [App\Http\Controllers\BranchAdminController::class, 'layananDelete'])->name('layanan.delete');

    // Klien/Mitra (FR-03)
    Route::get('/klien', [App\Http\Controllers\BranchAdminController::class, 'klien'])->name('klien.index');
    Route::post('/klien', [App\Http\Controllers\BranchAdminController::class, 'klienStore'])->name('klien.store');
    Route::get('/klien/{id}/edit', [App\Http\Controllers\BranchAdminController::class, 'klienEdit'])->name('klien.edit');
    Route::put('/klien/{id}', [App\Http\Controllers\BranchAdminController::class, 'klienUpdate'])->name('klien.update');
    Route::delete('/klien/{id}', [App\Http\Controllers\BranchAdminController::class, 'klienDelete'])->name('klien.delete');

    // Peserta & Riwayat (FR-04)
    Route::get('/peserta', [App\Http\Controllers\BranchAdminController::class, 'peserta'])->name('peserta.index');
    Route::post('/peserta', [App\Http\Controllers\BranchAdminController::class, 'pesertaStore'])->name('peserta.store');
    Route::get('/peserta/{id}/edit', [App\Http\Controllers\BranchAdminController::class, 'pesertaEdit'])->name('peserta.edit');
    Route::put('/peserta/{id}', [App\Http\Controllers\BranchAdminController::class, 'pesertaUpdate'])->name('peserta.update');
    Route::delete('/peserta/{id}', [App\Http\Controllers\BranchAdminController::class, 'pesertaDelete'])->name('peserta.delete');

    // Jadwal Pelatihan/Audit (FR-05)
    Route::get('/jadwal', [App\Http\Controllers\BranchAdminController::class, 'jadwal'])->name('jadwal.index');
    Route::post('/jadwal', [App\Http\Controllers\BranchAdminController::class, 'jadwalStore'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [App\Http\Controllers\BranchAdminController::class, 'jadwalEdit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [App\Http\Controllers\BranchAdminController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [App\Http\Controllers\BranchAdminController::class, 'jadwalDelete'])->name('jadwal.delete');

    // Sertifikat (FR-06)
    Route::get('/sertifikat', [App\Http\Controllers\BranchAdminController::class, 'sertifikat'])->name('sertifikat.index');
    Route::post('/sertifikat', [App\Http\Controllers\BranchAdminController::class, 'sertifikatStore'])->name('sertifikat.store');
    Route::get('/sertifikat/{id}/edit', [App\Http\Controllers\BranchAdminController::class, 'sertifikatEdit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{id}', [App\Http\Controllers\BranchAdminController::class, 'sertifikatUpdate'])->name('sertifikat.update');
    Route::delete('/sertifikat/{id}', [App\Http\Controllers\BranchAdminController::class, 'sertifikatDelete'])->name('sertifikat.delete');

    // Laporan (FR-07)
    Route::get('/laporan', [App\Http\Controllers\BranchAdminController::class, 'laporan'])->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});