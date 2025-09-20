<?php

namespace App\Filament\Admin\Resources\Forms\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Forms\FormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
