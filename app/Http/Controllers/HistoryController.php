<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use App\Models\RefractionTest;
use App\Models\ColorBlindTest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends Controller
{
   public function index()
{
    $user = auth()->user();
    
    // Hitung umur dari tanggal lahir
    $umur = $user->birth_date 
        ? \Carbon\Carbon::parse($user->birth_date)->age 
        : '-';

    // Ambil data diagnosa AI
    $diagnoses = Diagnosis::with('user')
        ->where('user_id', auth()->id())
        ->get()
        ->map(function ($item) use ($umur) {
            $item->source = 'ai';
            $item->patient_age = $umur; // 👈 Menambahkan umur ke objek
            return $item;
        });

    // Ambil data tes refraksi
    $refractions = RefractionTest::where('user_id', auth()->id())
        ->get()
        ->map(function ($item) use ($umur) {
            $item->source = 'refraksi';
            $item->patient_age = $umur; // 👈 Menambahkan umur ke objek
            $item->result = $item->type === 'minus'
                ? 'Refraksi Jarak Jauh - ' . $item->va_score
                : 'Refraksi Jarak Dekat - ' . $item->va_score;
            return $item;
        });

    // Ambil data skrining buta warna
    $colorBlindTests = ColorBlindTest::where('user_id', auth()->id())
        ->get()
        ->map(function ($item) use ($umur) {
            $item->source = 'butawarna';
            $item->patient_age = $umur; // 👈 Menambahkan umur ke objek
            $item->result = 'Skrining Buta Warna - ' . $item->status;
            return $item;
        });

    // ... sisa kode penggabungan $merged dan pagination tetap sama ...
    $merged = $diagnoses->concat($refractions)
        ->concat($colorBlindTests)
        ->sortByDesc('created_at')
        ->values();

    $perPage = 10;
    $currentPage = request()->get('page', 1);
    $paged = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $diagnosesPaginated = new LengthAwarePaginator(
        $paged,
        $merged->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('riwayat', ['diagnoses' => $diagnosesPaginated]);
}

    // 2. Cetak PDF Dokumen (hanya untuk hasil diagnosa AI)
    public function exportPdf($id)
    {
        $diagnosis = Diagnosis::with('user')
                              ->where('id', $id)
                              ->where('user_id', auth()->id())
                              ->firstOrFail();

        $pdf = Pdf::loadView('pdf.diagnosis_report', compact('diagnosis'));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Hasil_Diagnosa_EyeExpert_' . $diagnosis->created_at->format('Ymd') . '.pdf');
    }

    // 3. Lihat Detail Hasil Diagnosa AI (Tanpa Download PDF)
    public function show($id)
    {
        $diagnosis = Diagnosis::with('user')
                              ->where('id', $id)
                              ->where('user_id', auth()->id())
                              ->firstOrFail();

        return view('diagnosa_hasil', [
            'class'      => $diagnosis->result,
            'confidence' => $diagnosis->confidence,
            'message'    => 'Menampilkan arsip rekam medis terdahulu.',
            'validation' => 'success',
            'kesimpulan' => 'Data diambil dari arsip rekam medis terenkripsi milik pasien.',
            'image_path' => $diagnosis->image_path,
        ]);
    }

    // 4. Cetak PDF Hasil Tes Refraksi
    public function exportRefractionPdf($id)
    {
        $refraction = RefractionTest::with('user')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.refraction_report', compact('refraction'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Hasil_Refraksi_EyeExpert_' . $refraction->created_at->format('Ymd') . '.pdf');
    }

    // 5. Cetak PDF Hasil Skrining Buta Warna
    public function exportColorBlindPdf($id)
    {
        $colorBlind = ColorBlindTest::with('user')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.colorblind_report', compact('colorBlind'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Hasil_ButaWarna_EyeExpert_' . $colorBlind->created_at->format('Ymd') . '.pdf');
    }

    // 6. Hapus Riwayat Massal (Bulk Delete) — mendukung 3 tabel via prefix id
    public function destroyBulk(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'string',
        ]);

        $aiIds  = [];
        $refIds = [];
        $cbIds  = [];

        // Pisahkan ID berdasarkan prefix: "ai-5", "ref-3", atau "cb-2"
        foreach ($request->ids as $rawId) {
            if (str_starts_with($rawId, 'ai-')) {
                $aiIds[] = (int) str_replace('ai-', '', $rawId);
            } elseif (str_starts_with($rawId, 'ref-')) {
                $refIds[] = (int) str_replace('ref-', '', $rawId);
            } elseif (str_starts_with($rawId, 'cb-')) {
                $cbIds[] = (int) str_replace('cb-', '', $rawId);
            }
        }

        $deletedCount = 0;

        if (!empty($aiIds)) {
            $deletedCount += Diagnosis::whereIn('id', $aiIds)
                ->where('user_id', auth()->id())
                ->delete();
        }

        if (!empty($refIds)) {
            $deletedCount += RefractionTest::whereIn('id', $refIds)
                ->where('user_id', auth()->id())
                ->delete();
        }

        if (!empty($cbIds)) {
            $deletedCount += ColorBlindTest::whereIn('id', $cbIds)
                ->where('user_id', auth()->id())
                ->delete();
        }

        return redirect()->back()->with('success', $deletedCount . ' rekam medis berhasil dihapus.');
    }
}