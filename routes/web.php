<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
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
Route::view('/training/{id}/register', 'pages.training-register')->name('training.register');

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
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
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
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});