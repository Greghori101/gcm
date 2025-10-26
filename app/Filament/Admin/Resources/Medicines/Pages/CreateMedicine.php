<?php

namespace App\Filament\Admin\Resources\Medicines\Pages;

use App\Filament\Admin\Resources\Medicines\MedicineResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicine extends CreateRecord
{
    protected static string $resource = MedicineResource::class;
}
