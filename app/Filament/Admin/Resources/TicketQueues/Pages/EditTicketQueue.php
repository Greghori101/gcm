<?php

namespace App\Filament\Admin\Resources\TicketQueues\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TicketQueues\TicketQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketQueue extends EditRecord
{
    protected static string $resource = TicketQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
