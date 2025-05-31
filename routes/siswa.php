<?php

use App\Http\Controllers\Siswa\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('siswa.dashboard');

    // View Raport
    Route::get('/raport', 'App\Http\Controllers\Siswa\RaportController@index')->name('siswa.raport.index');
    Route::get('/raport/{id}', 'App\Http\Controllers\Siswa\RaportController@show')->name('siswa.raport.show');

    // View Nilai
    Route::get('/nilai', 'App\Http\Controllers\Siswa\NilaiController@index')->name('siswa.nilai');
    Route::get('/nilai/{id}', 'App\Http\Controllers\Siswa\NilaiController@show')->name('siswa.nilai.detail');

    // View Hafalan
    Route::get('/hafalan', 'App\Http\Controllers\Siswa\HafalanController@index')->name('siswa.hafalan.index');

    // Profile
    Route::get('/profile', 'App\Http\Controllers\Siswa\ProfileController@edit')->name('siswa.profile.edit');
    Route::put('/profile', 'App\Http\Controllers\Siswa\ProfileController@update')->name('siswa.profile.update');
});
