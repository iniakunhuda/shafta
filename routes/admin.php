<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KalenderController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\KelasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\UserAdminController;
use App\Http\Controllers\Superadmin\UserSiswaController;

// Superadmin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::resource('user/siswa', UserSiswaController::class)->names('admin.user_siswa');
    Route::put('user/siswa/{user}/toggle-status', [UserSiswaController::class, 'toggleStatus'])->name('admin.user_siswa.toggle-status');
    Route::resource('user/admin', UserAdminController::class)->names('admin.user_admin');
    Route::put('user/admin/{user}/toggle-status', [UserAdminController::class, 'toggleStatus'])->name('admin.user_admin.toggle-status');

    // System Settings
    Route::get('/settings', 'App\Http\Controllers\Superadmin\SettingController@index')->name('admin.settings');
    Route::post('/settings', 'App\Http\Controllers\Superadmin\SettingController@update')->name('admin.settings.update');
});


// Admin Routes
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('kalender', KalenderController::class);
    Route::resource('tahun_ajaran', TahunAjaranController::class)->names('admin.tahun_ajaran');
    Route::put('tahun_ajaran/{id}/toggle-active',[TahunAjaranController::class, 'toggleActive'])
        ->name('admin.tahun_ajaran.toggle-active');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::resource('kelas', KelasController::class)->names('admin.kelas');
});
