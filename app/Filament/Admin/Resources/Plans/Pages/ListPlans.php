<?php

namespace App\Filament\Admin\Resources\Plans\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Plans\PlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
