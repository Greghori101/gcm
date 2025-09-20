<?php

namespace App\Filament\Admin\Resources\Medicines\Pages;

use Filament\Actions\EditAction;
use App\Filament\Admin\Resources\Medicines\MedicineResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicine extends ViewRecord
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
