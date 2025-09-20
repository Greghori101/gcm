<?php

namespace App\Filament\Admin\Resources\Addresses\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Addresses\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddresses extends ListRecords
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
