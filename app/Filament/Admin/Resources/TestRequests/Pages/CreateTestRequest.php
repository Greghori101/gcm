<?php

namespace App\Filament\Admin\Resources\TestRequests\Pages;

use App\Filament\Admin\Resources\TestRequests\TestRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestRequest extends CreateRecord
{
    protected static string $resource = TestRequestResource::class;
}
