<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect based on role for general dashboard
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin() || $user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isSiswa()) {
        return redirect()->route('siswa.dashboard');
    }

    // Fallback
    return view('dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/siswa.php';
