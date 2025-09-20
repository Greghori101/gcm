<?php

namespace App\Filament\Admin\Resources\Nurses\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Nurses\NurseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNurses extends ListRecords
{
    protected static string $resource = NurseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
