<?php

namespace App\Filament\Admin\Resources\TestRequestResource\Pages;

use App\Filament\Admin\Resources\TestRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestRequests extends ListRecords
{
    protected static string $resource = TestRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
