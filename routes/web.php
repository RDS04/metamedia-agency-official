<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomisiController;
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
    Route::post('/loginAdmin', 'adminlogin')->name('login.admin.process');
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
        Route::get('/laporan', 'laporanAgent')->name('laporan');

        // Agent Routes
        Route::get('/create', 'tambahAgent')->name('agen.Create');
        Route::post('/store', 'agenStore')->name('agen.Store');
        Route::get('/show', 'agenShow')->name('agen.Show');
        Route::get('/agent/{id}/edit', 'agenEdit')->name('agen.Edit')->whereNumber('id');
        Route::put('/agent/{id}', 'agenUpdate')->name('agen.Update')->whereNumber('id');
        Route::delete('/agent/{id}', 'agenDestroy')->name('agen.Destroy')->whereNumber('id');
    });

});

// Admin Routes (Separate from auth middleware)
Route::middleware('auth:admin')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/admin/dashboard', 'adminDashboard')
            ->name('dashboard.admin');
        Route::post('/admin/logout', 'adminLogout')
            ->name('logout.admin');
    });

    Route::controller(DashboardController::class)->group(function () {

        Route::get('/admin/listAgent', 'listAgent')
            ->name('listAgent');

        Route::patch('/agent/{id}/toggle', 'toggleAgent')
            ->name('agent.toggle')
            ->whereNumber('id');
        Route::get('/admin/priode', 'priode')->name('priode');
        Route::post('/admin/priode', 'periodeStore')->name('periode.store');
        Route::get('/admin/priode/{periode}/edit', 'periodeEdit')->name('periode.edit')->whereNumber('periode');
        Route::put('/admin/priode/{periode}', 'periodeUpdate')->name('periode.update')->whereNumber('periode');
        Route::delete('/admin/priode/{periode}', 'periodeDestroy')->name('periode.destroy')->whereNumber('periode');

    });

    Route::controller(KomisiController::class)->prefix('admin/komisi')->group(function () {
        Route::get('/mao', 'mao')->name('komisi.mao');
        Route::get('/dosen-karyawan', 'dosenKaryawan')->name('komisi.dosen-karyawan');
        Route::get('/mitra', 'mitra')->name('komisi.mitra');
        Route::post('/', 'store')->name('komisi.store');
        Route::put('/{komisi}', 'update')->name('komisi.update')->whereNumber('komisi');
        Route::delete('/{komisi}', 'destroy')->name('komisi.destroy')->whereNumber('komisi');
    });

});
