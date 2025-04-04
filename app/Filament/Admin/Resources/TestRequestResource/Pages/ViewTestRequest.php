<?php

namespace App\Filament\Admin\Resources\TestRequestResource\Pages;

use App\Filament\Admin\Resources\TestRequestResource;
use App\Models\TestRequest;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTestRequest extends ViewRecord
{
    protected static string $resource = TestRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-document-download')
                ->url(fn(TestRequest $record) => route('test-request-pdf', $record))
                ->openUrlInNewTab(),
        ];
    }
}
