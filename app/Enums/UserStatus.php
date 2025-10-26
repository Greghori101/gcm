<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case BLOCKED = 'blocked';

    public static function toArray(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::PENDING->value => 'Pending',
            self::BLOCKED->value => 'blocked',
        ];
    }
}
