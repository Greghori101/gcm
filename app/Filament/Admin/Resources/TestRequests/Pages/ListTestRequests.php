<?php

namespace App\Filament\Admin\Resources\TestRequests\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TestRequests\TestRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestRequests extends ListRecords
{
    protected static string $resource = TestRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
