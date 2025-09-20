<?php

namespace App\Filament\Admin\Resources\Tickets\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Tickets\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
