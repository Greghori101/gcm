<?php

namespace App\Enums;

enum Roles: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    case NURSE = 'nurse';

    public static function toArray(): array
    {
        return [
            self::SUPER_ADMIN->value => 'Super Admin',
            self::ADMIN->value => 'Admin',
            self::DOCTOR->value => 'Doctor',
            self::PATIENT->value => 'Patient',
            self::NURSE->value => 'Nurse',
        ];
    }
}