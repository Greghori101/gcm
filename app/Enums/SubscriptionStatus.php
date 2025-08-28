<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Canceled = 'canceled';
    case Expired = 'expired';
}
