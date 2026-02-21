<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StressAssessment;

class AssessmentExportController extends Controller
{
    public function exportPdf()
    {
        $user = Auth::user();

        // ambil data lengkap user ini
        $assessments = StressAssessment::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // kirim ke view
        $pdf = Pdf::loadView('user.export_pdf', [
            'assessments' => $assessments,
            'user' => $user
        ]);

        return $pdf->download('assessment_' . $user->name . '.pdf');
    }

    public function exportAnalysisPdf()
    {
        $user = Auth::user();

        // Get latest assessment and all assessments for comparison
        $latest = StressAssessment::where('user_id', $user->id)->latest()->first();
        $assessments = StressAssessment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (!$latest) {
            return back()->with('error', 'Belum ada data assessment untuk di-export.');
        }

        // Get previous for comparison
        $previous = $assessments->count() > 1 ? $assessments->get(1) : null;

        // Generate PDF
        $pdf = Pdf::loadView('user.export_analysis_pdf', [
            'user' => $user,
            'latest' => $latest,
            'previous' => $previous,
            'assessments' => $assessments
        ]);

        return $pdf->download('analisis_stress_' . $user->name . '.pdf');
    }
}