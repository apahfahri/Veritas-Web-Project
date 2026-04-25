<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');

Route::view('/login', 'pages.login')->name('login');
Route::view('/register', 'pages.register')->name('register');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
Route::view('/admin', 'pages.admin')->name('admin');


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