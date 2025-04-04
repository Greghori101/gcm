<?php

namespace App\Enums;

enum BloodTypes: string
{
    case A_POSITIVE = 'A+';
    case A_NEGATIVE = 'A-';
    case B_POSITIVE = 'B+';
    case B_NEGATIVE = 'B-';
    case AB_POSITIVE = 'AB+';
    case AB_NEGATIVE = 'AB-';
    case O_POSITIVE = 'O+';
    case O_NEGATIVE = 'O-';

    public static function toArray(): array
    {
        return [
            self::A_POSITIVE->value => 'A+',
            self::A_NEGATIVE->value => 'A-',
            self::B_POSITIVE->value => 'B+',
            self::B_NEGATIVE->value => 'B-',
            self::AB_POSITIVE->value => 'AB+',
            self::AB_NEGATIVE->value => 'AB-',
            self::O_POSITIVE->value => 'O+',
            self::O_NEGATIVE->value => 'O-',
        ];
    }
}
