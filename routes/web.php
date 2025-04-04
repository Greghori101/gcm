<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('prescription-pdf/{order}', [PdfController::class, 'prescriptionPdf'])->name('prescription-pdf');
Route::get('certificate-pdf/{order}', [PdfController::class, 'certificatePdf'])->name('certificate-pdf');
Route::get('test-request-pdf/{order}', [PdfController::class, 'testRequestPdf'])->name('test-request-pdf');
