<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Halaman Umum)
|--------------------------------------------------------------------------
*/

// Halaman Landing Page - Perkenalan & Edukasi Mata
Route::get('/', [PageController::class, 'landing'])->name('landing');

// Halaman Edukasi Publik (Akses Tanpa Harus Login)
Route::get('/gejala-mata', function () {
    return view('gejala-mata');
})->name('gejala.mata'); // Dipakai tombol "Pelajari Tentang Mata"

// Cadangan nama route lama agar tidak memicu eror di file Laravel Breeze bawaan
Route::get('/gejala-mata-alias', function () {
    return redirect()->route('gejala.mata');
})->name('gejala-mata');

Route::get('/penyakit-mata', function () {
    return view('penyakit-mata');
})->name('penyakit-mata');

Route::get('/pencegahan-mata', function () {
    return view('pencegahan-mata');
})->name('pencegahan-mata');

Route::get('/kacamata', function () {
    return view('kacamata');
})->name('kacamata');


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard - Redirect ke Landing Page setelah login
    Route::get('/dashboard', function () {
        return redirect()->route('landing');
    })->name('dashboard');

    // Fitur Diagnosa AI
    Route::prefix('diagnosa')->name('diagnosa.')->group(function () {
        Route::get('/', [DiagnosisController::class, 'index'])->name('index');
        Route::post('/', [DiagnosisController::class, 'store'])->name('store');
    });

    // Fitur Cek Minus/Plus Terpisah
    Route::get('/tes-minus-plus', function () {
        return view('tes_minus_plus');
    })->name('tes.minus_plus');

    // Fitur Cek Buta Warna Terpisah
    Route::get('/tes-buta-warna', function () {
        return view('tes_buta_warna');
    })->name('tes.buta_warna');

    // Fitur Riwayat & Cetak PDF
    Route::get('/riwayat', [\App\Http\Controllers\HistoryController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/pdf/{id}', [\App\Http\Controllers\HistoryController::class, 'exportPdf'])->name('riwayat.pdf');

    // Profile User (Dimasukkan ke dalam agar aman terlindungi auth)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    
}); // 💡 Penutup tunggal grup middleware auth yang sah dan pas!

require __DIR__.'/auth.php';