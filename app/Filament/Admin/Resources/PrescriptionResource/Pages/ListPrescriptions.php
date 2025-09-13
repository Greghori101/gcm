<?php

namespace App\Filament\Admin\Resources\PrescriptionResource\Pages;

use App\Filament\Admin\Resources\PrescriptionResource;
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
            PrescriptionResource\Widgets\CreatePrescriptionWidget::class,
        ];
    }
}
