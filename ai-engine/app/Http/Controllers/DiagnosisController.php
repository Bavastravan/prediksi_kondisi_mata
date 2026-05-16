<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DiagnosisController extends Controller
{
    public function index()
    {
        return view('diagnosa');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'age' => 'required|integer|min:1|max:120',
            'symptoms' => 'required|array',
            'eye_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Simpan Gambar ke Folder Storage (storage/app/public/eyes)
        $image = $request->file('eye_image');
        $imagePath = $image->store('eyes', 'public');

        // 3. Ambil Hasil Analisis dari API Python (FastAPI)
        try {
            $response = Http::attach(
                'file', file_get_contents(storage_path('app/public/' . $imagePath)), 'eye.jpg'
            )->post('http://localhost:8080/predict');

            $aiResult = $response->json();
            
            // Mengambil hasil class ("Bukan Mata", "Mata Normal", "Katarak", "Glaukoma")
            $aiPrediction = $aiResult['class'] ?? 'Mata Normal';
            
            // Python mengirim data confidence dalam skala 0-100 atau desimal 0-1
            $rawConfidence = $aiResult['confidence'] ?? 75;
            $aiConfidence = $rawConfidence > 1 ? $rawConfidence / 100 : $rawConfidence;
            
            $aiMessage = $aiResult['message'] ?? 'Analisis citra berhasil diproses.';
            $aiValidation = $aiResult['validation'] ?? null;

        } catch (\Exception $e) {
            // Fallback aman jika service FastAPI Python mati
            $aiPrediction = "Diagnosa Gagal";
            $aiConfidence = 0.0;
            $aiMessage = "Gagal terhubung ke Engine Kecerdasan Buatan.";
            $aiValidation = "Server Offline";
        }

        // 4. LOGIKA SISTEM PAKAR (Certainty Factor Dasar)
        $userSymptoms = $request->symptoms;
        $finalPrediction = $aiPrediction;
        $finalConfidence = $aiConfidence;

        if ($aiPrediction === "Diagnosa Gagal" || $aiPrediction === "Bukan Mata") {
            $finalPrediction = $aiPrediction;
            $finalConfidence = 0.0; 
        } else {
            // JIKA AI MENDETEKSI KATARAK
            if ($aiPrediction == "Katarak") {
                if (in_array('kabur', $userSymptoms)) $finalConfidence += 0.15;
                if (in_array('silau', $userSymptoms)) $finalConfidence += 0.10;
                if (in_array('selaput', $userSymptoms)) $finalConfidence += 0.05;
                
                // Cek faktor risiko usia (katarak dominan pada usia lanjut)
                if ($request->age < 40) $finalConfidence -= 0.20;
            } 
            
            // JIKA AI MENDETEKSI GLAUKOMA
            else if ($aiPrediction == "Glaukoma") {
                if (in_array('kabur', $userSymptoms)) $finalConfidence += 0.15;
                if (in_array('merah', $userSymptoms)) $finalConfidence += 0.10;
                if (in_array('silau', $userSymptoms)) $finalConfidence += 0.05;
                
                if ($request->age > 40) $finalConfidence += 0.05;
            }

            // JIKA AI BILANG NORMAL TAPI GEJALA KLINIS USER BANYAK
            if ($aiPrediction == "Mata Normal" && count($userSymptoms) >= 2) {
                if (in_array('kabur', $userSymptoms) || in_array('merah', $userSymptoms)) {
                    $finalPrediction = "Iritasi / Kelelahan Mata Berat";
                    $finalConfidence = 0.70;
                }
            }
        }

        // Konversi nilai desimal Certainty Factor menjadi nilai persentase bulat (0 - 100)
        $finalConfidencePercentage = max(0, min(99, round($finalConfidence * 100)));
        if ($aiPrediction === "Diagnosa Gagal" || $aiPrediction === "Bukan Mata") {
            $finalConfidencePercentage = $rawConfidence ?? 0;
        }

        // 5. Simpan Hasil Rekam Medis ke Database
        Diagnosis::create([
            'age' => $request->age,
            'symptoms' => json_encode($userSymptoms),
            'image_path' => $imagePath,
            'result' => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
        ]);

        // 6. Return ke file blade view hasil yang telah Anda buat
        return view('diagnosa_hasil', [
            'class' => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
            'message' => $aiMessage,
            'validation' => $aiValidation,
            'image_path' => $imagePath // Mengirim jalur gambar untuk ditampilkan jika perlu
        ]);
    }
}