<?php

namespace App\Filament\Admin\Resources\TestRequestResource\Pages;

use App\Filament\Admin\Resources\TestRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestRequest extends CreateRecord
{
    protected static string $resource = TestRequestResource::class;
}
