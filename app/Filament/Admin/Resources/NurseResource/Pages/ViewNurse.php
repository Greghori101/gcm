<?php

namespace App\Filament\Admin\Resources\NurseResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Admin\Resources\NurseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNurse extends ViewRecord
{
    protected static string $resource = NurseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
