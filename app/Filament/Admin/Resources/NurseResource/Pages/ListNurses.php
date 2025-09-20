<?php

namespace App\Filament\Admin\Resources\NurseResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\NurseResource;
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
