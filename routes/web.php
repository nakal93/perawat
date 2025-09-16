<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\ProfesiController;
use App\Http\Controllers\Admin\KategoriDokumenController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// QR Code routes (token-based public verification)
Route::get('/qr/v/{token}', [QRCodeController::class, 'publicToken'])->name('qr.public');
Route::get('/qr/{karyawan}', [QRCodeController::class, 'show'])->name('qr.show');
Route::post('/qr/verify', [QRCodeController::class, 'verify'])->name('qr.verify');

// Registration success page
Route::get('/registration-success', function () {
    return view('auth.registration-success');
})->name('registration.success');

// Protected routes
Route::middleware('auth')->group(function () {
    // QR Code download routes
    Route::get('/qr-code/download/{type?}', [QRCodeController::class, 'download'])->name('qr.download');
    Route::get('/qr-code/generate/{id}', [QRCodeController::class, 'generate'])->name('qr.generate');
    
    // Redirect dashboard based on role
    // Redirect dashboard based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'superuser') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('karyawan.dashboard');
    })->name('dashboard');

    // Karyawan routes
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/beranda', [KaryawanController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [KaryawanController::class, 'profile'])->name('profile');
        Route::post('/profile', [KaryawanController::class, 'updateProfile'])->name('profile.update');
        Route::post('/complete-registration', [KaryawanController::class, 'completeRegistration'])->name('complete');
    Route::get('/settings', [KaryawanController::class, 'settings'])->name('settings');
    Route::patch('/settings', [KaryawanController::class, 'updateSettings'])->name('settings.update');
    });

    // Document routes
    Route::prefix('dokumen')->name('dokumen.')->group(function () {
        Route::get('/', [DokumenController::class, 'index'])->name('index');
        Route::get('/create', [DokumenController::class, 'create'])->name('create');
        Route::post('/', [DokumenController::class, 'store'])->name('store');
    Route::get('/{dokumen}/download', [DokumenController::class, 'download'])->name('download');
        Route::delete('/{dokumen}', [DokumenController::class, 'destroy'])->name('destroy');
    });

    // QR Code routes
    Route::prefix('qr')->name('qr.')->group(function () {
        Route::get('/download-code/{type}', [QRCodeController::class, 'download'])->name('download-code');
    });

    // Admin routes
    Route::middleware('role:admin,superuser')->prefix('admin')->name('admin.')->group(function () {
    // Batasi parameter resource agar numerik supaya tidak bentrok dengan path khusus
    Route::pattern('statusPegawai', '[0-9]+');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Quick Actions routes
        Route::get('/karyawan', [AdminKaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/{karyawan}', [AdminKaryawanController::class, 'show'])->name('karyawan.show');
        Route::get('/karyawan/create', [\App\Http\Controllers\KaryawanController::class, 'adminCreate'])->name('karyawan.create');
        Route::get('/laporan', function() { return view('admin.laporan'); })->name('laporan');
        Route::get('/settings', function() { return view('admin.settings'); })->name('settings');
        
        // Approval routes
        Route::prefix('approval')->name('approval.')->group(function () {
            Route::get('/', [ApprovalController::class, 'index'])->name('index');
            Route::post('/approve/{user}', [ApprovalController::class, 'approve'])->name('approve');
            Route::post('/reject/{user}', [ApprovalController::class, 'reject'])->name('reject');
            Route::post('/bulk-approve', [ApprovalController::class, 'bulkApprove'])->name('bulk-approve');
            Route::post('/approve-all', [ApprovalController::class, 'approveAll'])->name('approve-all');
        });

        // Master data routes
        // Status Pegawai manage (letakkan sebelum resource agar tidak tertangkap oleh {statusPegawai})
        Route::get('status-pegawai/manage', [\App\Http\Controllers\Admin\StatusPegawaiController::class, 'manage'])->name('status-pegawai.manage');

        Route::resource('ruangan', RuanganController::class);
        Route::resource('profesi', ProfesiController::class);
        Route::resource('kategori-dokumen', KategoriDokumenController::class)
            ->parameters(['kategori-dokumen' => 'kategoriDokumen']);
        Route::resource('status-pegawai', \App\Http\Controllers\Admin\StatusPegawaiController::class)
            ->parameters(['status-pegawai' => 'statusPegawai']);
        
        // Document management routes
        Route::resource('dokumen', \App\Http\Controllers\Admin\DokumenController::class);
        Route::get('dokumen/{dokumen}/download', [\App\Http\Controllers\Admin\DokumenController::class, 'download'])->name('dokumen.download');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
