<?php

namespace App\Filament\Admin\Resources\Prescriptions\Pages;

use App\Filament\Admin\Resources\Prescriptions\Widgets\CreatePrescriptionWidget;
use App\Filament\Admin\Resources\Prescriptions\PrescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;

class ListPrescriptions extends ListRecords
{
    protected static string $resource = PrescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreatePrescriptionWidget::class,
        ];
    }
}
