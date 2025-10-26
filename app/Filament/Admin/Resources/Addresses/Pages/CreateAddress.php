<?php

namespace App\Filament\Admin\Resources\Addresses\Pages;

use App\Filament\Admin\Resources\Addresses\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAddress extends CreateRecord
{
    protected static string $resource = AddressResource::class;
}
