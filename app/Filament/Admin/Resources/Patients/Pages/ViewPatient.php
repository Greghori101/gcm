<?php

namespace App\Filament\Admin\Resources\Patients\Pages;

use Filament\Actions\EditAction;
use App\Filament\Admin\Resources\Patients\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
