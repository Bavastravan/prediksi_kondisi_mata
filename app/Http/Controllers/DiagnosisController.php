<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DiagnosisController extends Controller
{
    /**
     * Menampilkan halaman form upload dan input gejala
     */
    public function index()
    {
        return view('diagnosa');
    }

    /**
     * Memproses foto dan kuesioner gejala menggunakan gabungan AI + Sistem Pakar
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Form (Usia, Array Gejala Opsi, dan Gambar)
        $request->validate([
            'age' => 'required|integer|min:1|max:120',
            'symptoms' => 'nullable|array',
            'eye_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $userSymptoms = $request->input('symptoms', []);

        // 2. Simpan Gambar ke Folder Storage (storage/app/public/eyes)
        $image = $request->file('eye_image');
        $imagePath = $image->store('eyes', 'public');

        // 3. Ambil Hasil Analisis dari Engine Python
        try {
            $fileContent = file_get_contents(storage_path('app/public/' . $imagePath));
            
            $response = Http::attach('file', $fileContent, 'eye.jpg')
                            ->post('http://localhost:8080/predict'); 

            $aiResult = $response->json();
            
            $aiPrediction = $aiResult['prediction'] ?? 'normal';
            $rawConfidence = $aiResult['confidence'] ?? '75.00%';
            $aiConfidence = (float) str_replace('%', '', $rawConfidence) / 100; 
            
            $aiMessage = $aiResult['message'] ?? 'Analisis citra mata berhasil diproses oleh AI Engine.';
            $aiValidation = $aiResult['status'] ?? 'success';

        } catch (\Exception $e) {
            $aiPrediction = "diagnosa_gagal";
            $aiConfidence = 0.0;
            $aiMessage = "Gagal terhubung ke Engine Kecerdasan Buatan (Server Offline).";
            $aiValidation = "error";
        }

        // 4. SISTEM PAKAR HIBRIDA + ANALISIS RAW PREDICTIONS DATASET MALPRAKTIK (ANTI-SPAM TOTAL)
        $finalPrediction = "";
        $finalConfidence = $aiConfidence;

        // 📊 1. Hitung Skor Kecurigaan Gejala Berdasarkan Bobot Medis
        $scoreHordeolum = 0;
        $scoreBelekan   = 0;
        $scoreUveitis   = 0;
        $scoreCataract  = 0;

        if (in_array('benjolan', $userSymptoms))  $scoreHordeolum += 0.40;
        if (in_array('nyeri', $userSymptoms))     $scoreHordeolum += 0.20;

        if (in_array('lengket', $userSymptoms))   $scoreBelekan   += 0.50;
        if (in_array('merah', $userSymptoms))     $scoreBelekan   += 0.15;

        if (in_array('silau', $userSymptoms))      $scoreUveitis   += 0.40;
        if (in_array('pupil_aneh', $userSymptoms)) $scoreUveitis   += 0.30;
        if (in_array('merah', $userSymptoms))      $scoreUveitis   += 0.10;

        if (in_array('selaput', $userSymptoms))   $scoreCataract  += 0.45;
        if (in_array('kabur', $userSymptoms))     $scoreCataract  += 0.25;

        $maxGejalaScore = max($scoreHordeolum, $scoreBelekan, $scoreUveitis, $scoreCataract);
        $totalCentangGejala = count($userSymptoms);

        // 📊 2. Ekstraksi Nilai Distribusi Probabilitas Mentah dari Dataset Python
        $rawNormalScore    = isset($aiResult['raw_predictions']['normal']) ? (float) str_replace('%', '', $aiResult['raw_predictions']['normal']) : 0.0;
        $rawBukanMataScore = isset($aiResult['raw_predictions']['bukan_mata']) ? (float) str_replace('%', '', $aiResult['raw_predictions']['bukan_mata']) : 0.0;
        $rawUveitisScore   = isset($aiResult['raw_predictions']['uveitis_peradangan']) ? (float) str_replace('%', '', $aiResult['raw_predictions']['uveitis_peradangan']) : 0.0;
        $rawBelekanScore   = isset($aiResult['raw_predictions']['eksudat_belekan']) ? (float) str_replace('%', '', $aiResult['raw_predictions']['eksudat_belekan']) : 0.0;
        $rawCataractScore  = isset($aiResult['raw_predictions']['cataract']) ? (float) str_replace('%', '', $aiResult['raw_predictions']['cataract']) : 0.0;
        $rawHordeolumScore = isset($aiResult['raw_predictions']['hordeolum_bintitan']) ? (float) str_replace('%', '', $aiResult['raw_predictions']['hordeolum_bintitan']) : 0.0;

        // 🧠 CRITICAL CLINICAL CHECK: FILTER ANATOMI BENTUK MATA MANUSIA
        $isAnatomiBukanMata = false;
        if ($aiConfidence <= 0.45) { $isAnatomiBukanMata = true; }
        elseif (($rawUveitisScore > 70.0 || $rawBelekanScore > 70.0 || $rawCataractScore > 70.0 || $rawHordeolumScore > 70.0) && $rawNormalScore < 1.00) { $isAnatomiBukanMata = true; }
        elseif ($rawBukanMataScore >= 30.0) { $isAnatomiBukanMata = true; }

        // 🧠 CRITICAL STEP: PEMBEDA MEDIS MUTLAK ANTARA UVEITIS VS BELEKAN
        if (!$isAnatomiBukanMata) {
            if (in_array('silau', $userSymptoms) || in_array('pupil_aneh', $userSymptoms)) {
                if (!in_array('lengket', $userSymptoms)) { $aiPrediction = "uveitis_peradangan"; }
            }
            if (in_array('lengket', $userSymptoms) && !in_array('silau', $userSymptoms)) {
                $aiPrediction = "eksudat_belekan";
            }
        }

        // 🛑 GERBANG 3: FILTER KEAMANAN
        if ($totalCentangGejala >= 5 || $isAnatomiBukanMata) {
            $finalPrediction = "Data Inputan Gagal Terdiagnosa";
            $finalConfidence = 0.0;
            $aiValidation = "error";
        }
        elseif (($aiPrediction === "bukan_mata" || $aiPrediction === "diagnosa_gagal") && ($totalCentangGejala >= 1 && $totalCentangGejala <= 3)) {
            if (in_array('kabur', $userSymptoms) && $totalCentangGejala === 1) {
                $finalPrediction = "Mata Normal (Indikasi Gangguan Refraksi)";
                $finalConfidence = 0.70;
                $aiValidation = "success";
            } 
            elseif ($scoreCataract >= 0.45) { $aiPrediction = "cataract"; } 
            elseif ($scoreHordeolum >= 0.40) { $aiPrediction = "hordeolum_bintitan"; } 
            elseif ($scoreBelekan >= 0.50) { $aiPrediction = "eksudat_belekan"; } 
            else {
                $finalPrediction = "Mata Sehat (Gejala Iritasi Ringan)";
                $finalConfidence = 0.60;
                $aiValidation = "success";
            }
        }
        elseif ($aiPrediction === "diagnosa_gagal" || $aiPrediction === "bukan_mata") {
            $finalPrediction = "Data Inputan Gagal Terdiagnosa";
            $finalConfidence = 0.0;
            $aiValidation = "error";
        }

       // 🔍 GERBANG VALIDASI MEDIS STANDAR (ATURAN NUKLIR MUTLAK)
        if ($finalPrediction === "") {
            
            // Uveitis WAJIB merah DAN silau (Tidak boleh cuma salah satu)
            if ($aiPrediction === "uveitis_peradangan" && (!in_array('merah', $userSymptoms) || !in_array('silau', $userSymptoms))) {
                $finalPrediction = "Data Inputan Gagal Terdiagnosa"; $finalConfidence = 0.0; $aiValidation = "error";
            }
            // Belekan WAJIB merah DAN lengket (Mencegah taplak lolos karena cuma centang lengket)
            elseif ($aiPrediction === "eksudat_belekan" && (!in_array('merah', $userSymptoms) || !in_array('lengket', $userSymptoms))) {
                $finalPrediction = "Data Inputan Gagal Terdiagnosa"; $finalConfidence = 0.0; $aiValidation = "error";
            }
            // Katarak WAJIB kabur DAN selaput
            elseif ($aiPrediction === "cataract" && (!in_array('kabur', $userSymptoms) || !in_array('selaput', $userSymptoms))) {
                $finalPrediction = "Data Inputan Gagal Terdiagnosa"; $finalConfidence = 0.0; $aiValidation = "error";
            }
            // Bintitan WAJIB ada benjolan
            elseif ($aiPrediction === "hordeolum_bintitan" && !in_array('benjolan', $userSymptoms)) {
                $finalPrediction = "Data Inputan Gagal Terdiagnosa"; $finalConfidence = 0.0; $aiValidation = "error";
            }
            
            // KUNCI PARADOKS MATA NORMAL
            elseif ($aiPrediction === "normal") {
                $gejalaFisikKeras = ['merah', 'lengket', 'benjolan', 'selaput', 'pupil_aneh', 'silau', 'nyeri'];
                $adaGejalaFisikKeras = count(array_intersect($userSymptoms, $gejalaFisikKeras)) > 0;

                if ($maxGejalaScore >= 0.35) {
                    if ($maxGejalaScore === $scoreHordeolum) { $aiPrediction = "hordeolum_bintitan"; $finalConfidence = 0.45 + $scoreHordeolum * (1 - 0.45); } 
                    elseif ($maxGejalaScore === $scoreBelekan) { $aiPrediction = "eksudat_belekan"; $finalConfidence = 0.45 + $scoreBelekan * (1 - 0.45); }
                    elseif ($maxGejalaScore === $scoreUveitis) { $aiPrediction = "uveitis_peradangan"; $finalConfidence = 0.40 + $scoreUveitis * (1 - 0.40); }
                    elseif ($maxGejalaScore === $scoreCataract) { $aiPrediction = "cataract"; $finalConfidence = 0.35 + $scoreCataract * (1 - 0.35); }
                }
                elseif ($adaGejalaFisikKeras) {
                    $finalPrediction = "Data Inputan Gagal Terdiagnosa"; 
                    $finalConfidence = 0.0; 
                    $aiValidation = "error";
                }
            }
        }

        // 🧠 4. ALUR EVALUASI KEPUTUSAN PENYAKIT AKHIR
        if ($finalPrediction === "") {
            if ($aiPrediction == "cataract") {
                $finalPrediction = "Katarak";
                $finalConfidence = ($scoreCataract > 0) ? $aiConfidence + $scoreCataract * (1 - $aiConfidence) : $aiConfidence;
                if ($request->age < 40) $finalConfidence = max(0.10, $finalConfidence - 0.15);
            } 
            elseif ($aiPrediction == "hordeolum_bintitan") {
                $finalPrediction = "Hordeolum (Bintitan)";
                $finalConfidence = ($scoreHordeolum > 0) ? $aiConfidence + $scoreHordeolum * (1 - $aiConfidence) : $aiConfidence;
            }
            elseif ($aiPrediction == "uveitis_peradangan") {
                $finalPrediction = "Uveitis (Peradangan Mata Dalam)";
                $finalConfidence = ($scoreUveitis > 0) ? $aiConfidence + $scoreUveitis * (1 - $aiConfidence) : $aiConfidence;
            }
            elseif ($aiPrediction == "eksudat_belekan") {
                $finalPrediction = "Konjungtivitis (Mata Merah / Belekan)";
                $finalConfidence = ($scoreBelekan > 0) ? $aiConfidence + $scoreBelekan * (1 - $aiConfidence) : $aiConfidence;
            }
            elseif ($aiPrediction == "normal") {
                if (in_array('kabur', $userSymptoms) && $totalCentangGejala === 1) {
                    $finalPrediction = "Mata Normal (Indikasi Gangguan Refraksi)";
                    $finalConfidence = max(0.70, $aiConfidence); // Ambil nilai yg lebih logis
                } else {
                    $finalPrediction = "Mata Sehat & Normal";
                    if ($totalCentangGejala > 0) $finalConfidence = max(0.60, $finalConfidence - 0.10);
                }
            }
            else {
                $finalPrediction = "Data Inputan Gagal Terdiagnosa";
                $finalConfidence = 0.0;
            }
        }

        // 5. Normalisasi Batas Skor Persentase Akhir (5% - 100%)
        $finalConfidencePercentage = max(5, min(100, round($finalConfidence * 100)));
        
        // KUNCI AMAN MATI PERSENTASE
        if ($finalPrediction === "Data Inputan Gagal Terdiagnosa" || $finalPrediction === "Diagnosa Sistem Gagal") {
            $finalPrediction = "Data Inputan Gagal Terdiagnosa";
            $finalConfidencePercentage = 0;
        }
        // 6. Simpan Histori Lengkap ke Database
        Diagnosis::create([
            'age' => $request->age,
            'symptoms' => json_encode($userSymptoms), 
            'image_path' => $imagePath,
            'result' => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
        ]);

        // 7. Render Hasil Akhir Ke Halaman `diagnosa_hasil`
        return view('diagnosa_hasil', [
            'class' => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
            'message' => $aiMessage,
            'validation' => $aiValidation,
            'image_path' => $imagePath 
        ]);
    }
}