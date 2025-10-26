<?php

namespace App\Filament\Admin\Resources\TicketQueues\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TicketQueues\TicketQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketQueues extends ListRecords
{
    protected static string $resource = TicketQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
