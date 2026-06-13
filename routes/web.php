<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

// Route::controller(FormController::class)->prefix('form')->group(function () {

//     Route::get('/', 'index')->name('showName');

//     Route::post('/', 'store')->name('forms.store');

//     Route::get('/dashboard', 'dashboard')->name('dashboard');

//     Route::get('/selamat', 'selamat')->name('selamat');

//     Route::get('/show', 'show')->name('show');

//     Route::get('/edit', 'edit')->name('edit');

//     Route::put('/mahasiswa/update', 'update')->name('form.update');
// });
Route::controller(AuthController::class)->prefix('auth')->group(function () {

    Route::get('/login', 'login')->name('auth.login');
    Route::get('/register', 'register')->name('auth.register');
    Route::post('/login', 'loginProcess')->name('login.proses');
    Route::post('/register', 'registerStore')->name('register.store');
    Route::put('/logout', 'logout')->name('auth.logout');
    Route::get('/logout','logout')->name('logout');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'informasi')->name('informasi');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/tambahAgent','tambahAgent')->name('Add.agent');
});