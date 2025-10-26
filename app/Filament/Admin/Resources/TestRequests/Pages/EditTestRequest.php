<?php

namespace App\Filament\Admin\Resources\TestRequests\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TestRequests\TestRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestRequest extends EditRecord
{
    protected static string $resource = TestRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
