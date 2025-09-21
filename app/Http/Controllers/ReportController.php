<?php

namespace App\Http\Controllers;

use App\Services\ReportPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function downloadComprehensiveReport(Request $request)
    {
        $filters = $request->all();
        
        // Clean up empty values
        $filters = array_filter($filters, function($value) {
            return !empty($value);
        });

        $pdfService = new ReportPdfService();
        return $pdfService->generateComprehensiveReportPdf($filters);
    }
}
