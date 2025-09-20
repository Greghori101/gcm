<?php

namespace App\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
