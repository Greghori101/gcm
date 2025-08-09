<?php

namespace App\Filament\Admin\Resources\TicketQueueResource\Pages;

use App\Filament\Admin\Resources\TicketQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketQueue extends CreateRecord
{
    protected static string $resource = TicketQueueResource::class;
}
