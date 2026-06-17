<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    public function index()
    {
        return view('diagnosa');
    }

    public function store(Request $request)
    {
        set_time_limit(300);

        // ===== 1. PENCEGAHAN FORM KOSONG AKIBAT XAMPP =====
        if (empty($request->all()) && $request->isMethod('post')) {
            return back()->withErrors(['eye_image' => 'Ukuran file gambar terlalu besar dan ditolak oleh server. Maksimal 5MB.']);
        }

        // ===== 2. VALIDASI INPUT =====
        $request->validate([
            'age'       => 'required|integer|min:1|max:120',
            'eye_image' => 'required|file|max:10240', // naik ke 10MB
        ], [
            'age.required'       => 'Usia kronologis pasien wajib diisi.',
            'eye_image.required' => 'Anda belum memilih foto mata untuk dianalisis.',
            'eye_image.max'      => 'Ukuran foto maksimal adalah 10 MB.',
        ]);

        // ===== 3. SIMPAN GAMBAR =====
        $uploadedFile = $request->file('eye_image');

        if (!$uploadedFile || !$uploadedFile->isValid()) {
            $errorCode = $uploadedFile ? $uploadedFile->getError() : 4;
            $errorMessages = [
                1 => 'File melebihi batas upload_max_filesize di php.ini.',
                2 => 'File melebihi batas MAX_FILE_SIZE di form.',
                3 => 'File hanya terupload sebagian.',
                4 => 'Tidak ada file yang dikirim.',
                6 => 'Folder temporary tidak ditemukan (sys_temp_dir).',
                7 => 'Gagal menulis file ke disk.',
                8 => 'Upload diblokir oleh ekstensi PHP.',
            ];
            $errorMsg = $errorMessages[$errorCode] ?? 'Error upload tidak diketahui (kode: ' . $errorCode . ')';
            Log::error('File upload invalid', ['error_code' => $errorCode, 'message' => $errorMsg]);
            return back()->withErrors(['eye_image' => 'Gagal upload: ' . $errorMsg]);
        }

        $imagePath     = $uploadedFile->store('eyes', 'public');
        $fullImagePath = storage_path('app/public/' . $imagePath);

        Log::info('File uploaded successfully', [
            'image_path'      => $imagePath,
            'full_image_path' => $fullImagePath,
        ]);

        // ===== 4. PANGGIL FASTAPI / EXEC PYTHON =====
        $rawPrediction = '';
        $aiConfidence  = 0.0;
        $aiMessage     = 'Analisis citra mata berhasil diproses oleh AI Engine.';
        $aiValidation  = 'success';

        $aiEngineUrl = env('AI_ENGINE_URL', 'http://127.0.0.1:8080');
        $usesFastApi = !empty($aiEngineUrl);

        if ($usesFastApi) {
            try {
                $response = Http::timeout(60)
                    ->attach('file', file_get_contents($fullImagePath), basename($fullImagePath))
                    ->post($aiEngineUrl . '/predict');

                if ($response->successful()) {
                    $result = $response->json();
                    
                    if (isset($result['prediction']) || isset($result['class'])) {
                        $rawPrediction = $result['prediction'] ?? $result['class'];
                        
                        $conf = $result['confidence'] ?? 0;
                        $aiConfidence = is_string($conf)
                            ? floatval(str_replace('%', '', $conf)) / 100
                            : (floatval($conf) > 1 ? floatval($conf) / 100 : floatval($conf));
                    } else {
                        throw new \Exception('Response FastAPI tidak memiliki field prediction.');
                    }
                } else {
                    throw new \Exception('FastAPI error HTTP ' . $response->status());
                }

            } catch (\Exception $e) {
                Log::warning('FastAPI gagal, fallback ke exec Python', ['error' => $e->getMessage()]);
                [$rawPrediction, $aiConfidence, $aiMessage, $aiValidation] = $this->runPythonExec($fullImagePath);
            }
        } else {
            [$rawPrediction, $aiConfidence, $aiMessage, $aiValidation] = $this->runPythonExec($fullImagePath);
        }

        // ===== 5. SISTEM KEYWORD MATCHING (SANGAT TANGGUH) =====
        // Ini memastikan apapun format teks dari Python, akan terdeteksi dengan tepat
        $rawLow = strtolower((string) $rawPrediction);
        $aiPrediction = 'diagnosa_gagal';

        if (str_contains($rawLow, 'cataract') || str_contains($rawLow, 'katarak')) {
            $aiPrediction = 'cataract';
        } elseif (str_contains($rawLow, 'pterygium') || str_contains($rawLow, 'daging')) {
            $aiPrediction = 'daging_tumbuh_pterygium';
        } elseif (str_contains($rawLow, 'hordeolum') || str_contains($rawLow, 'bintitan')) {
            $aiPrediction = 'hordeolum_bintitan';
        } elseif (str_contains($rawLow, 'iritasi')) {
            $aiPrediction = 'iritasi_mata';
        } elseif (str_contains($rawLow, 'hermohage') || str_contains($rawLow, 'hemorrhage') || str_contains($rawLow, 'berdarah')) {
            $aiPrediction = 'mata_berdarah_hermohage';
        } elseif (str_contains($rawLow, 'kacamata')) {
            $aiPrediction = 'mata_berkacamata';
        } elseif (str_contains($rawLow, 'bukan') || str_contains($rawLow, 'invalid')) {
            $aiPrediction = 'bukan_mata';
        } elseif (str_contains($rawLow, 'normal') || str_contains($rawLow, 'sehat')) {
            $aiPrediction = 'normal';
        }

        // Map ke nama tampilan
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

        // ===== 6. HITUNG CONFIDENCE =====
        if (in_array($aiPrediction, ['diagnosa_gagal', 'bukan_mata', 'mata_berkacamata'])) {
            $finalConfidencePercentage = 0;
            $aiValidation = 'error';
        } else {
            $finalConfidencePercentage = min(100, max(1, round($aiConfidence * 100)));
        }

        // ===== 7. KESIMPULAN MEDIS =====
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
                default                                      => 'Analisis tidak dapat diselesaikan. Pastikan foto mata jelas dan coba ulangi diagnosa.',
            };
        }

        // ===== 8. SIMPAN KE DATABASE =====
        Diagnosis::create([
            'user_id'    => Auth::id(),
            'age'        => $request->age,
            'symptoms'   => json_encode([]),
            'image_path' => $imagePath,
            'result'     => $finalPrediction,
            'confidence' => $finalConfidencePercentage,
        ]);

        // ===== 9. TAMPILKAN HASIL =====
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
     * Fallback: Jalankan prediksi via exec() Python langsung
     */
    private function runPythonExec(string $fullImagePath): array
    {
        $rawPrediction = 'diagnosa_gagal';
        $aiConfidence  = 0.0;
        $aiMessage     = 'Analisis citra mata berhasil diproses oleh AI Engine.';
        $aiValidation  = 'success';

        try {
            $pythonPath = env('AI_PYTHON_PATH', $this->getPythonPath());
            $scriptPath = base_path('ai-engine/predict.py');

            if (PHP_OS_FAMILY === 'Windows') {
                $fullImagePath = str_replace('/', '\\', $fullImagePath);
                $scriptPath    = str_replace('/', '\\', $scriptPath);
                $pythonPath    = str_replace('/', '\\', $pythonPath);
            }

            $command = '"' . $pythonPath . '" "' . $scriptPath . '" "' . $fullImagePath . '" 2>&1';
            exec($command, $outputArray, $returnCode);
            $output = implode("\n", $outputArray);

            $lines    = array_values(array_filter(array_map('trim', explode("\n", $output))));
            $jsonLine = null;
            for ($i = count($lines) - 1; $i >= 0; $i--) {
                if (str_contains($lines[$i], '{') && str_contains($lines[$i], '}')) {
                    $jsonLine = $lines[$i];
                    break;
                }
            }

            if ($jsonLine) {
                $aiResult = json_decode($jsonLine, true);
                if (isset($aiResult['prediction']) || isset($aiResult['class'])) {
                    $rawPrediction = $aiResult['prediction'] ?? $aiResult['class'];
                    
                    $conf = $aiResult['confidence'] ?? '0';
                    $aiConfidence = floatval(str_replace('%', '', (string)$conf));
                    if ($aiConfidence > 1) {
                        $aiConfidence /= 100;
                    }
                }
            }

        } catch (\Exception $e) {
            $rawPrediction = 'diagnosa_gagal';
            $aiConfidence  = 0.0;
            $aiMessage     = 'Gagal menjalankan Engine AI: ' . $e->getMessage();
            $aiValidation  = 'error';
        }

        return [$rawPrediction, $aiConfidence, $aiMessage, $aiValidation];
    }

    private function getPythonPath(): string
    {
        $isWindows = PHP_OS_FAMILY === 'Windows';
        $potentialPaths = $isWindows ? [
            base_path('ai-engine\\venv\\Scripts\\python.exe'),
            base_path('ai-engine/venv/Scripts/python.exe'),
            'python.exe',
            'python',
        ] : [
            base_path('ai-engine/venv/bin/python3'),
            base_path('ai-engine/venv/bin/python'),
            '/usr/bin/python3',
            '/usr/bin/python',
            'python3',
            'python',
        ];

        foreach ($potentialPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        return $isWindows ? 'python' : 'python3';
    }
}