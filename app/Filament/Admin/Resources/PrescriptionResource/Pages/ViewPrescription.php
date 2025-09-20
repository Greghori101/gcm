<?php

namespace App\Filament\Admin\Resources\PrescriptionResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\Action;
use App\Filament\Admin\Resources\PrescriptionResource;
use App\Models\Prescription;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPrescription extends ViewRecord
{
    protected static string $resource = PrescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn(Prescription $record) => route('prescription-pdf', $record))
                ->openUrlInNewTab(),
        ];
    }
}
