<?php

namespace App\Filament\Admin\Resources\TicketQueues\Pages;

use App\Filament\Admin\Resources\TicketQueues\TicketQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketQueue extends CreateRecord
{
    protected static string $resource = TicketQueueResource::class;
}
