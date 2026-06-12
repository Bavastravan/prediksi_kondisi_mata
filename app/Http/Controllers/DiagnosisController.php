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
        // Beri waktu 5 menit untuk AI berpikir
        set_time_limit(300);

        // 1. Validasi Input (Hanya Umur & Gambar)
        $request->validate([
            'age'       => 'required|integer|min:1|max:120',
            'eye_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // 2. Simpan Gambar
        $imagePath     = $request->file('eye_image')->store('eyes', 'public');
        $fullImagePath = storage_path('app/public/' . $imagePath);

        // 3. Jalankan Python AI Engine
        $aiPrediction   = 'normal';
        $aiConfidence   = 0.0;
        $aiMessage      = 'Analisis citra mata berhasil diproses oleh AI Engine.';
        $aiValidation   = 'success';

        try {
            $pythonPath = base_path('ai-engine/venv/Scripts/python.exe');
            $scriptPath = base_path('ai-engine/predict.py');
            
            // Eksekusi dengan 2>&1 untuk menangkap error Python
            $command    = '"' . $pythonPath . '" "' . $scriptPath . '" "' . $fullImagePath . '" 2>&1';
            $output     = shell_exec($command);

            $lines    = array_filter(array_map('trim', explode("\n", trim($output ?? ''))));
            $jsonLine = end($lines);
            $aiResult = json_decode($jsonLine, true);

            if (!$aiResult || ($aiResult['status'] ?? '') !== 'success') {
                throw new \Exception('Output AI tidak valid: ' . $jsonLine);
            }

            $aiPrediction = $aiResult['prediction'] ?? 'normal';
            $aiConfidence = floatval(str_replace('%', '', $aiResult['confidence'] ?? '0'));

        } catch (\Exception $e) {
            $aiPrediction = 'diagnosa_gagal';
            $aiConfidence = 0.0;
            $aiMessage    = 'Gagal menjalankan Engine AI: ' . $e->getMessage();
            $aiValidation = 'error';
        }

        // 4. Map nama kelas Python (8 Kelas Terbaru) ke nama tampilan Website
        $classMap = [
            'bukan_mata'              => 'Bukan Mata',
            'cataract'                => 'Katarak',
            'daging_tumbuh_pterygium' => 'Pterygium (Daging Tumbuh)',
            'hordeolum_bintitan'      => 'Hordeolum (Bintitan)',
            'iritasi_mata'            => 'Iritasi Mata',
            'mata_berdarah_hermohage' => 'Hemorrhage (Mata Berdarah)',
            'mata_berkacamata'        => 'Mata Berkacamata',
            'normal'                  => 'Mata Sehat & Normal',
            'diagnosa_gagal'          => 'Diagnosa Gagal',
        ];

        $finalPrediction = $classMap[$aiPrediction] ?? 'Diagnosa Gagal';
        
        // Pastikan persentase 0% JIKA Bukan Mata, Mata Berkacamata, atau Gagal
        if ($aiPrediction === 'diagnosa_gagal' || $aiPrediction === 'bukan_mata' || $aiPrediction === 'mata_berkacamata') {
            $finalConfidencePercentage = 0;
            // Jika ditolak, kita ubah status validation agar tampilannya merah/warning di hasil
            $aiValidation = 'error'; 
        } else {
            $finalConfidencePercentage = min(100, max(1, round($aiConfidence)));
        }

        // 5. Buat Kesimpulan Medis Khusus
        if ($aiPrediction === 'mata_berkacamata') {
            // Kita gunakan tag HTML agar kata "disini" bisa diklik
            $kesimpulan = 'Lepas kacamata atau aksesoris Anda terlebih dahulu agar proses diagnosa akurat. Anda juga dapat melihat jenis-jenis kacamata yang sesuai untuk Anda <a href="' . route('kacamata.index') . '" class="text-blue-600 underline font-bold hover:text-blue-800">disini</a>.';
        } else {
            $kesimpulan = match (true) {
                str_contains($finalPrediction, 'Katarak')    => 'Terdeteksi indikasi Katarak. Segera konsultasikan ke dokter spesialis mata.',
                str_contains($finalPrediction, 'Pterygium')  => 'Terdeteksi Pterygium (Daging Tumbuh). Hindari paparan sinar matahari langsung.',
                str_contains($finalPrediction, 'Hordeolum')  => 'Terdeteksi Hordeolum (Bintitan). Hindari memencet dan kompres dengan air hangat.',
                str_contains($finalPrediction, 'Iritasi')    => 'Terdeteksi Iritasi Mata. Jaga kebersihan dan istirahatkan mata Anda.',
                str_contains($finalPrediction, 'Hemorrhage') => 'Terdeteksi Mata Berdarah. Jangan mengucek mata dan segera kunjungi klinik terdekat.',
                str_contains($finalPrediction, 'Sehat')      => 'Mata Sehat & Normal. Tidak terdeteksi kelainan visual yang signifikan.',
                str_contains($finalPrediction, 'Bukan Mata') => 'Gambar yang diunggah tidak dikenali sebagai organ mata. Mohon ulangi dengan foto yang benar.',
                default                                      => 'Analisis tidak dapat diselesaikan. Coba ulangi proses diagnosa.',
            };
        }

        // 6. Simpan ke Database
        Diagnosis::create([
            'user_id'    => auth()->id(),
            'age'        => $request->age,
            'symptoms'   => json_encode([]), 
            'image_path' => $imagePath,
            'result'     => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
        ]);

        // 7. Tampilkan ke Halaman Hasil
        return view('diagnosa_hasil', [
            'class'      => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
            'message'    => $aiMessage,
            'validation' => $aiValidation,
            // Kita harus memberitahu blade bahwa kesimpulan ini mengandung HTML murni
            'kesimpulan' => $kesimpulan, 
            'image_path' => $imagePath,
        ]);
    }

    
}