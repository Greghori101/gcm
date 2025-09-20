<?php

namespace App\Filament\Admin\Resources\FormResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\FormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
