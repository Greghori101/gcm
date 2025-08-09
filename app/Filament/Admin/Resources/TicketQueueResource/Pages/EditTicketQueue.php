<?php

namespace App\Filament\Admin\Resources\TicketQueueResource\Pages;

use App\Filament\Admin\Resources\TicketQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketQueue extends EditRecord
{
    protected static string $resource = TicketQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
