<?php

namespace App\Filament\Admin\Resources\Nurses\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Nurses\NurseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNurse extends EditRecord
{
    protected static string $resource = NurseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
