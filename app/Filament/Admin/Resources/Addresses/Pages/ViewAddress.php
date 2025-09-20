<?php

namespace App\Filament\Admin\Resources\Addresses\Pages;

use Filament\Actions\EditAction;
use App\Filament\Admin\Resources\Addresses\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAddress extends ViewRecord
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
