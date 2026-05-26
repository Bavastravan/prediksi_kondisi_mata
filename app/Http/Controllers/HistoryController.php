<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::where('user_id', auth()->id())
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        return view('riwayat', compact('diagnoses'));
    }

    public function exportPdf($id)
    {
        $diagnosis = Diagnosis::where('id', $id)
                              ->where('user_id', auth()->id())
                              ->firstOrFail();

        $pdf = Pdf::loadView('pdf.diagnosis_report', compact('diagnosis'));
        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Hasil_Diagnosa_EyeExpert_' . $diagnosis->created_at->format('Ymd') . '.pdf');
    }
}