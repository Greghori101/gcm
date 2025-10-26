<?php

namespace App\Filament\Admin\Resources\Prescriptions\Pages;

use App\Filament\Admin\Resources\Prescriptions\PrescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrescription extends CreateRecord
{
    protected static string $resource = PrescriptionResource::class;
}
