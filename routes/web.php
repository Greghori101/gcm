<?php

use App\Filament\Admin\Pages\Blocked;
use App\Filament\Admin\Pages\Pending;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

use App\Models\Plan;

Route::get('/', function () {
    $plans = Plan::with('features')->get();
    return view('welcome', compact('plans'));
});

Route::get('/admin/pending', Pending::class)->name('filament.admin.pages.pending')->middleware(['auth', 'user-status-check']);

Route::get('/admin/blocked', Blocked::class)->name('filament.admin.pages.blocked')->middleware(['auth', 'user-status-check']);

Route::get('prescription-pdf/{id}', [PdfController::class, 'prescriptionPdf'])->name('prescription-pdf');
Route::get('certificate-pdf/{id}', [PdfController::class, 'certificatePdf'])->name('certificate-pdf');
Route::get('test-request-pdf/{id}', [PdfController::class, 'testRequestPdf'])->name('test-request-pdf');
