<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
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
            'age'       => 'required|integer|min:1|max:120',
            'symptoms'  => 'required|array',
            'eye_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Simpan Gambar ke Folder Storage (storage/app/public/eyes)
        $image     = $request->file('eye_image');
        $imagePath = $image->store('eyes', 'public');

        // 3. Ambil Hasil Analisis langsung dari predict.py
        try {
            $fullImagePath = storage_path('app/public/' . $imagePath);

            // Path python di dalam venv (Windows)
            $pythonPath = base_path('ai-engine/venv/Scripts/python.exe');
            $scriptPath = base_path('ai-engine/predict.py');

            // Jalankan predict.py dan ambil output
            $command = '"' . $pythonPath . '" "' . $scriptPath . '" "' . $fullImagePath . '" 2>&1';
            $output  = shell_exec($command);

            // Ambil baris terakhir yang berisi JSON
            $lines    = array_filter(array_map('trim', explode("\n", trim($output))));
            $jsonLine = end($lines);
            $aiResult = json_decode($jsonLine, true);

            if (!$aiResult || $aiResult['status'] !== 'success') {
                throw new \Exception('Output AI tidak valid: ' . $jsonLine);
            }

            $rawPrediction = $aiResult['prediction'] ?? 'normal';

            // Map nama kelas Python ke nama tampilan
            $classMap = [
                'cataract'           => 'Katarak',
                'normal'             => 'Mata Normal',
                'bukan_mata'         => 'Bukan Mata',
                'eksudat_belekan'    => 'Eksudat / Belekan',
                'hordeolum_bintitan' => 'Hordeolum / Bintitan',
                'uveitis_peradangan' => 'Uveitis / Peradangan',
            ];

            $aiPrediction  = $classMap[$rawPrediction] ?? 'Mata Normal';
            $rawConfidence = floatval(str_replace('%', '', $aiResult['confidence'] ?? '75'));
            $aiConfidence  = $rawConfidence / 100;
            $aiMessage     = 'Analisis citra berhasil diproses oleh Computer Vision.';
            $aiValidation  = null;

        } catch (\Exception $e) {
            $aiPrediction  = 'Diagnosa Gagal';
            $aiConfidence  = 0.0;
            $aiMessage     = 'Gagal menjalankan Engine AI: ' . $e->getMessage();
            $aiValidation  = 'Error';
            $rawConfidence = 0;
        }

        // 4. LOGIKA SISTEM PAKAR (Certainty Factor)
        $userSymptoms    = $request->symptoms;
        $finalPrediction = $aiPrediction;
        $finalConfidence = $aiConfidence;

        if ($aiPrediction === 'Diagnosa Gagal' || $aiPrediction === 'Bukan Mata') {
            $finalPrediction = $aiPrediction;
            $finalConfidence = 0.0;

        } else {
            // KATARAK
            if ($aiPrediction === 'Katarak') {
                if (in_array('kabur', $userSymptoms))   $finalConfidence += 0.15;
                if (in_array('silau', $userSymptoms))   $finalConfidence += 0.10;
                if (in_array('selaput', $userSymptoms)) $finalConfidence += 0.05;
                if ($request->age < 40)                 $finalConfidence -= 0.20;
            }

            // EKSUDAT / BELEKAN
            elseif ($aiPrediction === 'Eksudat / Belekan') {
                if (in_array('belekan', $userSymptoms)) $finalConfidence += 0.15;
                if (in_array('merah', $userSymptoms))   $finalConfidence += 0.10;
                if (in_array('gatal', $userSymptoms))   $finalConfidence += 0.10;
            }

            // HORDEOLUM / BINTITAN
            elseif ($aiPrediction === 'Hordeolum / Bintitan') {
                if (in_array('benjolan', $userSymptoms)) $finalConfidence += 0.15;
                if (in_array('merah', $userSymptoms))    $finalConfidence += 0.10;
                if (in_array('nyeri', $userSymptoms))    $finalConfidence += 0.10;
            }

            // UVEITIS / PERADANGAN
            elseif ($aiPrediction === 'Uveitis / Peradangan') {
                if (in_array('merah', $userSymptoms))  $finalConfidence += 0.15;
                if (in_array('nyeri', $userSymptoms))  $finalConfidence += 0.10;
                if (in_array('kabur', $userSymptoms))  $finalConfidence += 0.10;
                if (in_array('silau', $userSymptoms))  $finalConfidence += 0.05;
            }

            // MATA NORMAL tapi banyak gejala klinis
            if ($aiPrediction === 'Mata Normal' && count($userSymptoms) >= 2) {
                if (in_array('kabur', $userSymptoms) || in_array('merah', $userSymptoms)) {
                    $finalPrediction = 'Iritasi / Kelelahan Mata Berat';
                    $finalConfidence = 0.70;
                }
            }
        }

        // Konversi Certainty Factor ke persentase (0-100)
        $finalConfidencePercentage = max(0, min(99, round($finalConfidence * 100)));

        // Override untuk kasus gagal/bukan mata
        if ($aiPrediction === 'Diagnosa Gagal' || $aiPrediction === 'Bukan Mata') {
            $finalConfidencePercentage = 0;
        }

        // Tentukan kesimpulan akhir yang ditampilkan
        $kesimpulan = match ($finalPrediction) {
            'Katarak'                    => 'Terdeteksi indikasi Katarak. Segera konsultasikan ke dokter spesialis mata.',
            'Eksudat / Belekan'          => 'Terdeteksi Eksudat / Belekan. Jaga kebersihan mata dan konsultasikan ke dokter.',
            'Hordeolum / Bintitan'       => 'Terdeteksi Hordeolum (Bintitan). Hindari memencet dan konsultasikan ke dokter.',
            'Uveitis / Peradangan'       => 'Terdeteksi Uveitis / Peradangan. Segera konsultasikan ke dokter spesialis mata.',
            'Mata Normal'                => 'Mata Sehat & Normal. Tidak terdeteksi kelainan signifikan.',
            'Iritasi / Kelelahan Mata Berat' => 'Terdeteksi Iritasi / Kelelahan Mata. Istirahatkan mata dan konsultasikan jika berlanjut.',
            'Bukan Mata'                 => 'Gambar yang diunggah bukan gambar mata. Silakan ulangi dengan foto mata yang benar.',
            default                      => 'Analisis tidak dapat diselesaikan. Coba ulangi proses diagnosa.',
        };

        // 5. Simpan Hasil ke Database
        Diagnosis::create([
            'age'        => $request->age,
            'symptoms'   => json_encode($userSymptoms),
            'image_path' => $imagePath,
            'result'     => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
        ]);

        // 6. Kirim ke View Hasil
        return view('diagnosa_hasil', [
            'class'       => $finalPrediction,
            'confidence'  => $finalConfidencePercentage,
            'message'     => $aiMessage,
            'validation'  => $aiValidation,
            'kesimpulan'  => $kesimpulan,
            'image_path'  => $imagePath,
        ]);
    }
}