<?php

namespace App\Filament\Admin\Resources\Doctors\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Doctors\DoctorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctors extends ListRecords
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
