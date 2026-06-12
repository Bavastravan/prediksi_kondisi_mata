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

    // Profile User
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
    
});

require __DIR__.'/auth.php';