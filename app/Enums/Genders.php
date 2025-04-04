<?php

namespace App\Enums;

enum Genders: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function toArray(): array
    {
        return [
            self::MALE->value => 'Male',
            self::FEMALE->value => 'Female',
        ];
    }
}
