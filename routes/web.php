<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\PesanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ExportregisController;

// Public Routes
Route::controller(DashboardController::class)->prefix('agent')->group(function () {
    Route::get('/', 'informasi')->name('informasi');
});

// Kepuasan Agent - store (publik, siapapun bisa submit)
Route::post('/agent/kepuasan', [PesanController::class, 'store'])->name('pesan.store');

// Authentication Routes (Guest Only)
Route::controller(AuthController::class)->prefix('agent')->middleware('guest')->group(function () {
    Route::get('/login', 'login')->name('auth.login');
    Route::get('/register', 'register')->name('auth.register');
    Route::post('/login', 'loginProcess')->name('login.proses');
    Route::post('/register', 'registerStore')->name('register.store');
    Route::post('/register/verify-otp', 'verifyRegistrationOtp')->name('register.verify-otp');
    Route::post('/register/resend-otp', 'resendRegistrationOtp')->name('register.resend-otp');
    Route::post('/register/change-data', 'changeRegistrationData')->name('register.change-data');
    Route::get('/registerAdmin', 'registerAdmin')->name('register.admin');
    Route::post('/registerAdmin', 'adminregisterStore')->name('adminregisterStore');

    // Forgot Password Routes
    Route::get('/forgot-password', 'forgotPassword')->name('password.request');
    Route::post('/forgot-password', 'sendResetOtp')->name('password.email');
    Route::post('/forgot-password/verify', 'verifyResetOtp')->name('password.verify-otp');
    Route::post('/forgot-password/resend', 'resendResetOtp')->name('password.resend-otp');
    Route::post('/forgot-password/cancel', 'cancelReset')->name('password.cancel');
    Route::post('/forgot-password/reset', 'resetPassword')->name('password.update');

});

// Authenticated Routes
Route::middleware('auth')->prefix('agent')->group(function () {

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
        Route::get('/agent/{id}', 'agenDetail')->name('agen.Detail')->whereNumber('id');
        Route::get('/agent/{id}/edit', 'agenEdit')->name('agen.Edit')->whereNumber('id');
        Route::put('/agent/{id}', 'agenUpdate')->name('agen.Update')->whereNumber('id');
        Route::delete('/agent/{id}', 'agenDestroy')->name('agen.Destroy')->whereNumber('id');
    });

});

// Admin Routes (Separate from auth middleware)
Route::middleware('auth:admin')->prefix('agent')->group(function () {

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
        Route::get('/admin/data-camaba', 'dataCamaba')->name('dataCamaba');
        Route::patch('/admin/data-camaba/{camaba}/status', 'updateCamabaStatus')->name('dataCamaba.status')->whereNumber('camaba');

    });

    Route::controller(KomisiController::class)->prefix('admin/komisi')->group(function () {
        Route::get('/mao', 'mao')->name('komisi.mao');
        Route::get('/dosen-karyawan', 'dosenKaryawan')->name('komisi.dosen-karyawan');
        Route::get('/mitra', 'mitra')->name('komisi.mitra');
        Route::post('/', 'store')->name('komisi.store');
        Route::put('/{komisi}', 'update')->name('komisi.update')->whereNumber('komisi');
        Route::delete('/{komisi}', 'destroy')->name('komisi.destroy')->whereNumber('komisi');
    });
    Route::controller(ImportController::class)->prefix('admin/mahasiswa')->group(function () {
        Route::get('/', 'indexMahasiswa')
            ->name('mahasiswa.index');

        Route::get('/create', 'createMahasiswa')
            ->name('mahasiswa.create');

        Route::post('/store', 'storeMahasiswa')
            ->name('mahasiswa.store');

        Route::post('/import', 'previewImport')
            ->name('mahasiswa.import');

        Route::post('/confirm-import', 'confirmImport')
            ->name('mahasiswa.confirm-import');

        Route::get('/download-template', 'downloadTemplate')
            ->name('mahasiswa.download-template');

        Route::get('/export', 'exportMahasiswa')
            ->name('mahasiswa.export');

        Route::get('/{id}/edit', 'editMahasiswa')
            ->name('mahasiswa.edit')
            ->whereNumber('id');

        Route::put('/{id}', 'updateMahasiswa')
            ->name('mahasiswa.update')
            ->whereNumber('id');

        Route::delete('/{id}', 'destroyMahasiswa')
            ->name('mahasiswa.destroy')
            ->whereNumber('id');
    });

    // Kepuasan Agent - Admin CRUD
    Route::controller(PesanController::class)->prefix('admin/kepuasan')->group(function () {
        Route::get('/', 'index')->name('pesan.index');
        Route::get('/{pesan}', 'show')->name('pesan.show')->whereNumber('pesan');
        Route::patch('/{pesan}/toggle', 'toggleTampil')->name('pesan.toggle')->whereNumber('pesan');
        Route::delete('/{pesan}', 'destroy')->name('pesan.destroy')->whereNumber('pesan');
    });

    // Export Register Agent (Import via Excel)
    Route::controller(ExportregisController::class)->prefix('admin/export-register')->group(function () {
        Route::get('/', 'index')->name('exportregister.index');
        Route::post('/preview', 'preview')->name('exportregister.preview');
        Route::post('/confirm', 'confirm')->name('exportregister.confirm');
        Route::get('/template', 'downloadTemplate')->name('exportregister.template');
    });

});
