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
    public function prescriptionPdf($id)
    {
        $prescription =  Prescription::with([
            'patient.user',
            'patient.address',
            'prescriptionMedicines.medicine'
        ])->find($id);

        return Pdf::loadView('prescription-pdf', ['record' => $prescription])
            ->stream($prescription->nb . '.pdf');
    }

    public function certificatePdf($id)
    {
        $certificate = Certificate::findOrFail($id);
        return Pdf::loadView('certificate-pdf', ['record' => $certificate])
            ->stream($certificate->nb . '.pdf');
    }
    public function testRequestPdf($id)
    {
        $testRequest = TestRequest::findOrFail($id);
        return Pdf::loadView('test-request-pdf', ['record' => $testRequest])
            ->stream($testRequest->nb . '.pdf');
    }
}
