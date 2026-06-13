<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::controller(FormController::class)->prefix('form')->group(function () {

    Route::get('/', 'index')->name('showName');

    Route::post('/', 'store')->name('forms.store');

    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/selamat', 'selamat')->name('selamat');

    Route::get('/show', 'show')->name('show');

    Route::get('/edit', 'edit')->name('edit');

    Route::put('/mahasiswa/update', 'update')->name('form.update');
});