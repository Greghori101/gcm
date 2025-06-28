<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('prescription-pdf/{id}', [PdfController::class, 'prescriptionPdf'])->name('prescription-pdf');
Route::get('certificate-pdf/{id}', [PdfController::class, 'certificatePdf'])->name('certificate-pdf');
Route::get('test-request-pdf/{id}', [PdfController::class, 'testRequestPdf'])->name('test-request-pdf');
