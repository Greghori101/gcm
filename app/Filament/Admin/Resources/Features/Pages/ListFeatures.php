<?php

namespace App\Filament\Admin\Resources\Features\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Features\FeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeatures extends ListRecords
{
    protected static string $resource = FeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
