<?php

namespace App\Filament\Admin\Resources\Patients\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Patients\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
