<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

// Public Routes
Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'informasi')->name('informasi');
});

// Authentication Routes (Guest Only)
Route::controller(AuthController::class)->prefix('auth')->middleware('guest')->group(function () {
    Route::get('/login', 'login')->name('auth.login');
    Route::get('/register', 'register')->name('auth.register');
    Route::post('/login', 'loginProcess')->name('login.proses');
    Route::post('/register', 'registerStore')->name('register.store');
    Route::get('/loginAdmin', 'loginAdmin')->name('login.admin');
    Route::get('/registerAdmin', 'registerAdmin')->name('register.admin');
    Route::post('/loginAdmin', 'adminlogin')->name('login.admin');
    Route::post('/registerAdmin', 'adminregisterStore')->name('adminregisterStore');

});

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Auth Logout
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::put('/logout', 'logout')->name('auth.logout');
        Route::get('/logout', 'logout')->name('logout');
    });

    // Dashboard & Agent Management
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');

        // Agent Routes
        Route::get('/create', 'tambahAgent')->name('agen.Create');
        Route::post('/store', 'agenStore')->name('agen.Store');
        Route::get('/show', 'agenShow')->name('agen.Show');
        Route::get('/{id}/edit', 'agenEdit')->name('agen.Edit');
        Route::put('/{id}', 'agenUpdate')->name('agen.Update');
        Route::delete('/{id}', 'agenDestroy')->name('agen.Destroy');
    });

});
Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard.auth');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout.admin');

});

