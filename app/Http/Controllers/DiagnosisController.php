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
            // ===== PERBAIKAN KRITIS: Auto-detect Python path =====
            $pythonPath = $this->getPythonPath();
            $scriptPath = base_path('ai-engine/predict.py');
            
            // ===== PERBAIKAN KRITIS 2: Normalisasi path untuk Windows =====
            // Windows membutuhkan backslash, bukan forward slash
            if (PHP_OS_FAMILY === 'Windows') {
                $fullImagePath = str_replace('/', '\\', $fullImagePath);
                $scriptPath = str_replace('/', '\\', $scriptPath);
                $pythonPath = str_replace('/', '\\', $pythonPath);
            }
            
            // Validasi file ada sebelum eksekusi
            if (!file_exists($fullImagePath)) {
                throw new \Exception('File gambar tidak ditemukan: ' . $fullImagePath);
            }

            if (!file_exists($scriptPath)) {
                throw new \Exception('Script predict.py tidak ditemukan: ' . $scriptPath);
            }

            // ===== Buat command dengan proper escaping =====
            $command = $pythonPath . ' ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($fullImagePath);
            
            Log::info('Executing AI Engine', [
                'python_path' => $pythonPath,
                'script_path' => $scriptPath,
                'image_path' => $fullImagePath,
                'command' => $command
            ]);
            
            // ===== Jalankan dengan exec() dan return code checking =====
            exec($command . ' 2>&1', $outputArray, $returnCode);
            $output = implode("\n", $outputArray);

            if (empty($output)) {
                throw new \Exception('Python tidak menghasilkan output. Return code: ' . $returnCode);
            }

            Log::info('AI Engine Output', [
                'return_code' => $returnCode,
                'output_length' => strlen($output),
                'first_500_chars' => substr($output, 0, 500)
            ]);

            // ===== Parse output dengan robust error handling =====
            $lines = array_filter(array_map('trim', explode("\n", $output)));
            
            if (empty($lines)) {
                throw new \Exception('Output parsing gagal: tidak ada baris valid');
            }

            // Cari JSON dari belakang (mungkin ada warning di depan)
            $jsonLine = null;
            for ($i = count($lines) - 1; $i >= 0; $i--) {
                if (strpos($lines[$i], '{') !== false && strpos($lines[$i], '}') !== false) {
                    $jsonLine = $lines[$i];
                    break;
                }
            }

            if (!$jsonLine) {
                throw new \Exception('JSON tidak ditemukan. Last line: ' . end($lines));
            }

            // ===== Flexible JSON parsing =====
            $aiResult = json_decode($jsonLine, true);

            if ($aiResult === null) {
                throw new \Exception('Invalid JSON format: ' . $jsonLine);
            }

            // ===== Validasi response =====
            if (!isset($aiResult['prediction'])) {
                throw new \Exception('Missing "prediction" field in AI response');
            }

            $aiPrediction = $aiResult['prediction'];
            $confidence = $aiResult['confidence'] ?? '0';
            
            // Handle confidence (string atau number)
            $aiConfidence = floatval(str_replace('%', '', $confidence));
            
            // Normalize confidence ke 0-1 range
            if ($aiConfidence > 1) {
                $aiConfidence = $aiConfidence / 100;
            }

        } catch (\Exception $e) {
            $aiPrediction = 'diagnosa_gagal';
            $aiConfidence = 0.0;
            $aiMessage    = 'Gagal menjalankan Engine AI: ' . $e->getMessage();
            $aiValidation = 'error';
            
            Log::error('AI Engine Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'image_path' => $fullImagePath ?? 'undefined'
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
     * Auto-detect Python path berdasarkan OS
     * Mencari Python dari berbagai lokasi yang mungkin
     */
    private function getPythonPath()
    {
        $isWindows = PHP_OS_FAMILY === 'Windows';
        
        if ($isWindows) {
            // Prioritas path untuk Windows
            $potentialPaths = [
                base_path('ai-engine\\venv\\Scripts\\python.exe'),
                base_path('ai-engine/venv/Scripts/python.exe'),
                'python.exe',
                'python',
            ];
        } else {
            // Prioritas path untuk Linux/Mac
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
