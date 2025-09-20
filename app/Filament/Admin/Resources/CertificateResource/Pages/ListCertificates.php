<?php

namespace App\Filament\Admin\Resources\CertificateResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificates extends ListRecords
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
