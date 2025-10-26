<?php

namespace App\Enums;

enum TicketStatus: string
{
    //
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Expired = 'expired';
}
