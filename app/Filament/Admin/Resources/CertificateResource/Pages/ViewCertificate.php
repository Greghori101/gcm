<?php

namespace App\Filament\Admin\Resources\CertificateResource\Pages;

use App\Filament\Admin\Resources\CertificateResource;
use App\Models\Certificate;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCertificate extends ViewRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-document-download')
                ->url(fn(Certificate $record) => route('certificate-pdf', $record))
                ->openUrlInNewTab(),
        ];
    }
}
