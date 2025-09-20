<?php

namespace App\Filament\Admin\Resources\Medicines\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Medicines\MedicineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicines extends ListRecords
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
