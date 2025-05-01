<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KalenderController;
use App\Http\Controllers\Admin\TahunAjaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\UserAdminController;
use App\Http\Controllers\Superadmin\UserSiswaController;

// Superadmin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::resource('user/siswa', UserSiswaController::class);
    Route::resource('user/admin', UserAdminController::class);

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
    Route::resource('tahun_ajaran', TahunAjaranController::class);

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
