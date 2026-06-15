<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            // ===== PERBAIKAN 1: Auto-detect Python path (Windows/Linux/Mac) =====
            $pythonPath = $this->getPythonPath();
            $scriptPath = base_path('ai-engine/predict.py');
            
            // Validasi script ada
            if (!file_exists($scriptPath)) {
                throw new \Exception('Script predict.py tidak ditemukan di: ' . $scriptPath);
            }

            // ===== PERBAIKAN 2: Gunakan escapeshellarg untuk safety & compatibility =====
            if (PHP_OS_FAMILY === 'Windows') {
                $command = $pythonPath . ' ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($fullImagePath);
            } else {
                $command = $pythonPath . ' ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($fullImagePath);
            }
            
            Log::info('Executing AI command', ['python_path' => $pythonPath]);
            
            // ===== PERBAIKAN 3: Check if shell_exec is disabled =====
            if (function_exists('exec')) {
                exec($command . ' 2>&1', $outputArray, $returnCode);
                $output = implode("\n", $outputArray);
                
                if ($returnCode !== 0 && empty($output)) {
                    throw new \Exception('Python script error (return code: ' . $returnCode . '). Periksa Python path dan script.');
                }
            } else {
                throw new \Exception('shell_exec dan exec() di-disable di server ini.');
            }

            // ===== PERBAIKAN 4: Robust output parsing =====
            if (empty($output)) {
                throw new \Exception('AI Engine tidak menghasilkan output. Output kosong.');
            }

            Log::info('AI Engine output', ['output' => $output]);

            // Cari JSON terakhir dari output
            $lines = array_filter(array_map('trim', explode("\n", $output)));
            
            if (empty($lines)) {
                throw new \Exception('Output parsing gagal: tidak ada baris output.');
            }

            // Cari JSON dari belakang (karena mungkin ada output lain sebelumnya)
            $jsonLine = null;
            for ($i = count($lines) - 1; $i >= 0; $i--) {
                if (strpos($lines[$i], '{') !== false && strpos($lines[$i], '}') !== false) {
                    $jsonLine = $lines[$i];
                    break;
                }
            }

            if (!$jsonLine) {
                throw new \Exception('JSON tidak ditemukan di output: ' . substr($output, 0, 200));
            }

            // ===== PERBAIKAN 5: Flexible JSON parsing =====
            $aiResult = json_decode($jsonLine, true);

            if ($aiResult === null) {
                // Coba extract menggunakan regex jika JSON parsing gagal
                if (preg_match('/\"prediction\"\s*:\s*\"([^\"]+)\"/', $output, $predMatches) &&
                    preg_match('/\"confidence\"\s*:\s*(\d+(?:\.\d+)?)/', $output, $confMatches)) {
                    
                    $aiPrediction = $predMatches[1];
                    $aiConfidence = floatval($confMatches[1]);
                    if ($aiConfidence > 1) {
                        $aiConfidence = $aiConfidence / 100; // Normalize if percentage
                    }
                } else {
                    throw new \Exception('Invalid JSON format: ' . $jsonLine);
                }
            } else {
                // ===== PERBAIKAN 6: Flexible validation (tidak require 'status') =====
                if (!isset($aiResult['prediction'])) {
                    throw new \Exception('Missing prediction field in AI output');
                }

                $aiPrediction = $aiResult['prediction'] ?? 'normal';
                $confidence = $aiResult['confidence'] ?? '0';
                
                // Handle confidence sebagai string atau number
                $aiConfidence = floatval(str_replace('%', '', $confidence));
                
                // Normalize confidence (jika format 0-100, konversi ke 0-1)
                if ($aiConfidence > 1) {
                    $aiConfidence = $aiConfidence / 100;
                }
            }

        } catch (\Exception $e) {
            $aiPrediction = 'diagnosa_gagal';
            $aiConfidence = 0.0;
            $aiMessage    = 'Gagal menjalankan Engine AI: ' . $e->getMessage();
            $aiValidation = 'error';
            
            // Log untuk debugging
            Log::error('AI Engine Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
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
            $aiValidation = 'error'; 
        } else {
            $finalConfidencePercentage = min(100, max(1, round($aiConfidence * 100)));
        }

        // 5. Buat Kesimpulan Medis Khusus
        if ($aiPrediction === 'mata_berkacamata') {
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
            'kesimpulan' => $kesimpulan, 
            'image_path' => $imagePath,
        ]);
    }

    /**
     * ===== HELPER: Auto-detect Python path berdasarkan OS =====
     * Mengembalikan path Python yang sesuai dengan sistem operasi
     */
    private function getPythonPath()
    {
        $isWindows = PHP_OS_FAMILY === 'Windows';
        
        if ($isWindows) {
            // Windows paths
            $potentialPaths = [
                base_path('ai-engine\\venv\\Scripts\\python.exe'),
                base_path('ai-engine/venv/Scripts/python.exe'),
                'python.exe',
                'python',
            ];
        } else {
            // Linux/Mac paths
            $potentialPaths = [
                base_path('ai-engine/venv/bin/python3'),
                base_path('ai-engine/venv/bin/python'),
                '/usr/bin/python3',
                '/usr/bin/python',
                'python3',
                'python',
            ];
        }

        // Cari path pertama yang exists
        foreach ($potentialPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Fallback ke global python
        return $isWindows ? 'python' : 'python3';
    }
}
