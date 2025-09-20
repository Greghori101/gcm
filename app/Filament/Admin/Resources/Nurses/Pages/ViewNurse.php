<?php

namespace App\Filament\Admin\Resources\Nurses\Pages;

use Filament\Actions\EditAction;
use App\Filament\Admin\Resources\Nurses\NurseResource;
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
