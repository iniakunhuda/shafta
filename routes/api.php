<?php

use App\Http\Controllers\Admin\KalenderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/kalender', [KalenderController::class, 'api'])->name('api.kalender.index');

Route::get('/kalender', [KalenderController::class, 'api'])->name('api.kalender.index');
Route::post('/kalender', [KalenderController::class, 'store'])->name('api.kalender.store');
Route::put('/kalender/{id}', [KalenderController::class, 'update'])->name('api.kalender.update');
Route::delete('/kalender/{id}', [KalenderController::class, 'destroy'])->name('api.kalender.destroy');
