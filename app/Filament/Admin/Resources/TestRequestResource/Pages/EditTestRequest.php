<?php

namespace App\Filament\Admin\Resources\TestRequestResource\Pages;

use App\Filament\Admin\Resources\TestRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestRequest extends EditRecord
{
    protected static string $resource = TestRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
