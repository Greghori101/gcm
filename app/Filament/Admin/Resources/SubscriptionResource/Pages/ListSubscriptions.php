<?php

namespace App\Filament\Admin\Resources\SubscriptionResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\SubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
