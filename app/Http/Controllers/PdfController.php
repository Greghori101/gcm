<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Prescription;
use App\Models\TestRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //
    public function prescriptionPdf(Prescription $prescription)
    {
        return Pdf::loadView('prescription-pdf', ['record' => $prescription])
            ->stream($prescription->nb . '.pdf');
    }

    public function certificatePdf(Certificate $certificate)
    {
        return Pdf::loadView('certificate-pdf', ['record' => $certificate])
            ->stream($certificate->nb . '.pdf');
    }
    public function testRequestPdf(TestRequest $testRequest)
    {
        return Pdf::loadView('test-request-pdf', ['record' => $testRequest])
            ->stream($testRequest->nb . '.pdf');
    }
}
