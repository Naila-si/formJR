<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormulirController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Login & Register
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

// === Tambahkan ini untuk Formulir ===
Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.index');
Route::post('/formulir', [FormulirController::class, 'store'])->name('formulir.store');
