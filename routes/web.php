<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\ManifestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin1\IwklController;
use App\Http\Controllers\Admin1\IwkbuController;
use App\Http\Controllers\Admin1\RkcrmController;
use App\Http\Controllers\Admin1\DashboardController;

// ========================
// HALAMAN UTAMA
// ========================
Route::get('/', function () {
    return view('app');
});

// ========================
// LOGIN & REGISTER
// ========================
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login/custom', [LoginController::class, 'loginCustom'])->name('login.custom');

Route::get('/register', function () {
    return view('register');
})->name('register');

// ========================
// DASHBOARD (Admin/User)
// ========================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin1.dashboard');

// ========================
// FORMULIR (Frontend)
// ========================
Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.index');
Route::post('/formulir', [FormulirController::class, 'store'])->name('formulir.store');
Route::get('/get-os/{nopol}', [FormulirController::class, 'getOutstanding'])->name('get-os');

// ========================
// MANIFEST
// ========================
Route::get('/manifest', [ManifestController::class, 'index'])->name('manifest.index');
Route::post('/manifest', [ManifestController::class, 'store'])->name('manifest.store');

// ========================
// ADMIN ROUTES
// ========================
Route::prefix('admin1')->name('admin1.')->group(function () {
    // FORMULIR - ADMIN
    Route::get('/formulir', [FormulirController::class, 'adminIndex'])->name('formulir.index');
    Route::get('/formulir/{id}/edit', [FormulirController::class, 'edit'])->name('formulir.edit');
    Route::put('/formulir/{id}', [FormulirController::class, 'update'])->name('formulir.update');
    Route::delete('/formulir/{id}', [FormulirController::class, 'destroy'])->name('formulir.destroy');

    // IWKBU
    Route::get('iwkbu', [IwkbuController::class, 'index'])->name('iwkbu.index');
    Route::get('iwkbu/{id}/edit', [IwkbuController::class, 'edit'])->name('iwkbu.edit');
    Route::put('iwkbu/{id}', [IwkbuController::class, 'update'])->name('iwkbu.update');
    Route::post('iwkbu/import', [IwkbuController::class, 'import'])->name('iwkbu.import');
    Route::get('iwkbu/export/excel', [IwkbuController::class, 'exportExcel'])->name('iwkbu.export.excel');
    Route::get('iwkbu/export/pdf', [IwkbuController::class, 'exportPdf'])->name('iwkbu.export.pdf');
    Route::get('iwkbu/{id}', [IwkbuController::class, 'show'])->name('iwkbu.show');

    // IWKL
    Route::get('iwkl', [IwklController::class, 'index'])->name('iwkl.index');
    Route::post('iwkl/import', [IwklController::class, 'import'])->name('iwkl.import');
    Route::get('iwkl/export/excel', [IwklController::class, 'exportExcel'])->name('iwkl.export.excel');
    Route::get('iwkl/export/pdf', [IwklController::class, 'exportPdf'])->name('iwkl.export.pdf');

    // RKCRM
    Route::get('/rkcrm', [RkcrmController::class, 'index'])->name('rkcrm.index');
    Route::post('/rkcrm/import', [RkcrmController::class, 'import'])->name('rkcrm.import');
    Route::get('/rkcrm/export/excel', [RkcrmController::class, 'exportExcel'])->name('rkcrm.export.excel');
    Route::get('/rkcrm/export/pdf', [RkcrmController::class, 'exportPDF'])->name('rkcrm.export.pdf');
    Route::get('/rkcrm/edit/{id}', [RkcrmController::class, 'edit'])->name('rkcrm.edit');
});
