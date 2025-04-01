<?php

namespace App\Filament\Admin\Resources\NurseResource\Pages;

use App\Filament\Admin\Resources\NurseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNurse extends EditRecord
{
    protected static string $resource = NurseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
