<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefractionTest;
use Illuminate\Support\Facades\Log;

class RefractionTestController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'type'       => 'required|in:minus,plus',
            'va_score'   => 'required|string|max:50',
            'conclusion' => 'required|string',
            'confidence' => 'required|integer|min:0|max:100',
        ]);

        try {
            // 2. Tambahkan user_id yang sedang login
            $validated['user_id'] = auth()->id();

            // 3. Simpan ke database
            RefractionTest::create($validated);

            // 4. Return success
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ], 200);

        } catch (\Exception $e) {
            // Log error ke file storage/logs/laravel.log agar bisa dicek jika gagal
            Log::error('Gagal menyimpan tes refraksi: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database'
            ], 500);
        }
    }
}