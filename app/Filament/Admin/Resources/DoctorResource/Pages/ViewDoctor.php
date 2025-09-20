<?php

namespace App\Filament\Admin\Resources\DoctorResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Admin\Resources\DoctorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDoctor extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
