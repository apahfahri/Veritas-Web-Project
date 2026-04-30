<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');

// Redirect /home ke beranda (untuk backward compat & middleware redirect fallback)
Route::redirect('/home', '/');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// Guest only (redirect ke dashboard jika sudah login)
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class,    'showForm'])->name('login');
    Route::post('/login',    [LoginController::class,    'login']);
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Google OAuth (tidak perlu middleware guest karena bisa update google_id user yang sudah ada)
Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
    Route::view('/admin',     'pages.admin')->name('admin');
});


/*
|--------------------------------------------------------------------------
| SERVICES
|--------------------------------------------------------------------------
*/

Route::prefix('training')->group(function () {

    // LIST
    Route::get('/', function () {
        return view('pages.training-list');
    })->name('training.list');

    // DETAIL (WAJIB ADA ID)
    Route::get('/{id}', function ($id) {
        return view('pages.training-detail', compact('id'));
    })->name('training.detail');

    // REGISTER
    Route::get('/{id}/register', function ($id) {
        return view('pages.training-register', compact('id'));
    })->name('training.register');

});


Route::view('/consultation', 'pages.consultation')->name('consultation');

Route::view('/audit', 'pages.audit')->name('audit');

Route::view('/verification', 'pages.verification')->name('verification');


/*
|--------------------------------------------------------------------------
| FALLBACK (OPTIONAL)
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});