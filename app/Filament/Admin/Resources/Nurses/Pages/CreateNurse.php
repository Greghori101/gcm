<?php

namespace App\Filament\Admin\Resources\Nurses\Pages;

use App\Filament\Admin\Resources\Nurses\NurseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNurse extends CreateRecord
{
    protected static string $resource = NurseResource::class;
}
