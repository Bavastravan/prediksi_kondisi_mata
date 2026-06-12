<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefractionTestController;
use App\Http\Controllers\ColorBlindTestController;


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
})->name('gejala.mata');

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

// URL /kacamata diletakkan di sini agar bisa diakses publik
Route::get('/kacamata', function () {
    return view('kacamata');
})->name('kacamata.index');


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
    
    // Proses simpan tes refraksi
    Route::post('/refraksi/store', [RefractionTestController::class, 'store'])->name('refraksi.store');

    // Fitur Cek Buta Warna Terpisah
    Route::get('/tes-buta-warna', function () {
        return view('tes_buta_warna');
    })->name('tes.buta_warna');
    
    // Proses simpan tes buta warna (URL disamakan dengan JS fetch API)
    Route::post('/simpan-buta-warna', [ColorBlindTestController::class, 'store'])->name('butawarna.store');

    // Fitur Riwayat & Cetak PDF (Dikelompokkan menggunakan prefix)
    Route::prefix('riwayat')->name('riwayat.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/{id}/show', [HistoryController::class, 'show'])->name('show');
        Route::delete('/destroy-bulk', [HistoryController::class, 'destroyBulk'])->name('destroy_bulk');
        
        // Rute Cetak PDF
        Route::get('/pdf/{id}', [HistoryController::class, 'exportPdf'])->name('pdf');
        Route::get('/refraksi/{id}/pdf', [HistoryController::class, 'exportRefractionPdf'])->name('refraksi.pdf');
        Route::get('/buta-warna/{id}/pdf', [HistoryController::class, 'exportColorBlindPdf'])->name('butawarna.pdf');
    });

    // Profile User
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

}); // Penutup tunggal grup middleware auth yang sah dan pas!

require __DIR__.'/auth.php';